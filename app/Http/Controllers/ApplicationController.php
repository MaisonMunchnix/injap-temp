<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\Product;
use App\Package;
use App\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    /**
     * Check if an application code is valid and unused (for real-time UI validation)
     */
    public function checkApplicationCode($code)
    {
        $valid = \App\ApplicationCode::where('code', $code)
            ->where('is_used', false)
            ->exists();

        return response()->json(['valid' => $valid]);
    }

    /**
     * Store application submission
     */
    public function submitApplication(Request $request)
    {
        // Get valid package types for validation
        $validPackageTypes = DB::table('packages')
            ->where('status', 1)
            ->pluck('type')
            ->toArray();
        
        $validTypes = implode(',', $validPackageTypes);
        
        $validated = $request->validate([
            'product_code' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'birthday' => 'required|date',
            'sponsor_id' => 'nullable|string|max:50',
            'address' => 'required|string|max:500',
            'member_type' => 'required|in:' . $validTypes,
            'agreeTerms' => 'required|accepted',
            'proof_of_payment' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);

        // Validate Product Code
        $appCode = \App\ApplicationCode::where('code', $validated['product_code'])
            ->where('is_used', false)
            ->first();

        if (!$appCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or already used Product Code. Please ensure you enter a valid 8-digit generated code.'
            ], 422);
        }

        // Validate that sponsor exists (only if sponsor_id is provided)
        if (!empty($validated['sponsor_id'])) {
            $sponsor = User::where('username', $validated['sponsor_id'])
                ->orWhere('email', $validated['sponsor_id'])
                ->orWhere('sponsor_id', $validated['sponsor_id'])
                ->orWhere('affiliate_link', $validated['sponsor_id'])
                ->first();
            
            if (!$sponsor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sponsor ID not found. Please enter a valid sponsor username, email, or sponsor ID.'
                ], 422);
            }
        }

        DB::beginTransaction();
        try {
            // Use the username provided by the user
            $username = $validated['username'];

            // Generate temporary password
            $tempPassword = \Illuminate\Support\Str::random(12);

            $package = Package::where('type',$validated['member_type'])->first();

            // Create user with pending status
            $user = User::create([
                'username' => $username,
                'email' => $validated['email'],
                'password' => bcrypt($tempPassword),
                'plain_password' => $tempPassword,
                'status' => 0,  // Pending approval (0 = inactive)
                'userType' => 'user',
                'member_type' => $validated['member_type'],
                'account_type' => $package->id ?? 1,
                'is_application_approved' => 0  // New field to track approval
            ]);

            // Create user info
            UserInfo::create([
                'user_id' => $user->id,
                'first_name' => $validated['name'],
                'last_name' => '',
                'mobile_no' => $validated['phone'],
                'birthdate' => $validated['birthday'],
                'country_name' => $validated['country'],
                'address' => $validated['address']
            ]);

            // Handle file upload
            if ($request->hasFile('proof_of_payment')) {
                $file = $request->file('proof_of_payment');
                $fileName = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadDir = public_path('application_attachments/' . $user->id);
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Store file in public directory
                $file->move($uploadDir, $fileName);
                $filePath = 'application_attachments/' . $user->id . '/' . $fileName;
                
                // Store attachment record
                \App\ApplicationAttachment::create([
                    'user_id' => $user->id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_type' => 'proof_of_payment',
                    'original_name' => $file->getClientOriginalName()
                ]);
            }

            // Generate this user's own Sponsor ID based on member type
            $generatedSponsorId = $this->generateSponsorId($validated['member_type']);

            // Store application details for admin review
            DB::table('user_applications')->insert([
                'user_id' => $user->id,
                'product_code' => $validated['product_code'],
                'sponsor_id' => $generatedSponsorId,  // Store this user's generated Sponsor ID (same as affiliate_link)
                'sponsor_input' => $validated['sponsor_id'] ?? null,  // Store what the user entered (username/email/affiliate_link)
                'member_type' => $validated['member_type'],
                'status' => 'pending',  // pending, approved, rejected
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Mark product code as used
            $appCode->update([
                'is_used' => true,
                'user_id' => $user->id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully! Please wait for admin approval.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all pending applications (admin view)
     */
    public function getPendingApplications()
    {
        $applications = DB::table('user_applications')
            ->join('users', 'user_applications.user_id', '=', 'users.id')
            ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('application_attachments', function($join) {
                $join->on('users.id', '=', 'application_attachments.user_id')
                     ->where('application_attachments.file_type', '=', 'proof_of_payment');
            })
            ->where('user_applications.status', 'pending')
            ->select(
                'users.id as user_id',
                'users.username',
                'users.email',
                'user_infos.first_name',
                'user_infos.mobile_no',
                'user_infos.birthdate',
                'user_infos.country_name',
                'user_applications.product_code',
                'user_applications.sponsor_id',
                'user_applications.member_type',
                'user_applications.created_at',
                'application_attachments.file_path',
                'application_attachments.file_name'
            )
            ->orderBy('user_applications.created_at', 'desc')
            ->paginate(20);

        return view('admin.applications.pending', compact('applications'));
    }

    /**
     * Show approve application form (admin can set password)
     */
    public function showApproveForm($user_id)
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $user = User::with('info')->find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $application = DB::table('user_applications')
            ->where('user_id', $user_id)
            ->first();

        if (!$application || $application->status !== 'pending') {
            return redirect()->back()->with('error', 'Application is not pending');
        }

        return view('admin.applications.approve', compact('user', 'application'));
    }

    /**
     * Approve application with password and details
     */
    public function approveApplication(Request $request, $user_id)
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8'
        ]);

        DB::beginTransaction();
        try {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Get application details
            $application = DB::table('user_applications')
                ->where('user_id', $user_id)
                ->first();

            if (!$application || $application->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Application not found or already processed'], 404);
            }

            // Use the Sponsor ID that was already generated during submission
            $sponsorId = $application->sponsor_id;
            \Log::info("Using stored Sponsor ID: {$sponsorId} for user {$user_id}");

            // Check if this user had a sponsor in the application form
            $sponsorInput = $application->sponsor_input;
            
            $sponsor = null;
            $uplineSponsorId = 0;  // Default: no upline
            $placement_position = "";
            $upline_placement_id = 0;
            $sponsor_pr = $request['sponsor'];
            $upline_placement = $request['upline_placement'];//sponsor ID
            $desired_position = $request['position']; //left or right
            $sponsor_id = 0;
            $package_type = 1;

            //Check Register if users is null
            $check_users = User::where('userType', 'user')->count();
            $checkUser = User::where('id', $user_id)->first();
            if($checkUser){
                $package_type = $checkUser->account_type;
            }
            $package = Package::where('id', $package_type)->first();
           
            
            if (!empty($sponsorInput)) {
                // Find the sponsor by username, email, or sponsor_id
                $sponsor = User::where('username', $sponsorInput)
                    ->orWhere('email', $sponsorInput)
                    ->orWhere('sponsor_id', $sponsorInput)
                    ->orWhere('affiliate_link', $sponsorInput)
                    ->first();
                
                if ($sponsor) {
                    $uplineSponsorId = $sponsor->id;
                }
            }

            if ($check_users > 0) {
                //check sponsor
                $check_sponsor = DB::table('users')
                    ->select('id')
                    ->where('sponsor_id', $sponsor_pr)
                    ->where('userType', 'user')
                    ->first();
                if($check_sponsor){
                    $sponsor_id = $check_sponsor->id;
                }

                //check upline
                $check_upline = User::select('id')->where('sponsor_id',$upline_placement)->where('userType','user')->first();
                $valid_upline = false;
                if(!empty($check_upline)){
                    $upline_placement_id = $check_upline->id;
                    $networks = DB::table('networks')->where('upline_placement_id',$upline_placement_id)
                    ->where("sponsor_id", "!=", $upline_placement_id)
                    ->count();
                    if(!empty($networks)){
                        if($networks >= 2){
                            $valid_upline = false;
                        }else{
                            $valid_upline = true;
                        }
                    }else{
                        $valid_upline = true;
                    }
                }else{
                    $valid_upline = false;
                }
                if($valid_upline == true){
                    $placement_position = $this->getPlacementPosition($upline_placement_id, $desired_position);
                }
            } else {
                $upline_placement_id = 1;
                $sponsor_id = 1;
                $desired_position = 'Left';
                $valid_upline = true;
                $check_crosslining = true;
                $check_sponsor_crosslining = true;
            }

            // Update user with admin-set password and sponsor_id
            // affiliate_link remains as random string for backward compatibility
            $updateResult = $user->update([
                'password' => bcrypt($validated['password']),
                'plain_password' => $validated['password'],
                'status' => 1,  // Active
                'is_application_approved' => 1,
                'sponsor_id' => $sponsorId  // Set the auto-generated sponsor ID
            ]);

            $count_placement_id = Network::where('upline_placement_id', $upline_placement_id)->count();
            
            // normalize placement position to lowercase to avoid case mismatches
            $placement_position = !empty($placement_position) ? strtolower($placement_position) : null;

            // Create Network record for this user
            DB::table('networks')->insert([
                'user_id' => $user_id,
                'sponsor_id' => $sponsor_id,  // The upline sponsor's ID
                'upline_placement_id' => $upline_placement_id,
                'placement_position' => $placement_position,  // normalized to lowercase
                'count' => ($count_placement_id === 1 ? 2 : 1),
                'package' => $package_type,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \Log::info("Network inserted for user {$user_id} under upline {$upline_placement_id} pos={$placement_position}");

            // ===========================================================
            // Pairing Bonus
            // ===========================================================
            // $initialUpline = $upline_placement_id;
            // $initialChildren = DB::table('networks')
            //     ->where('upline_placement_id', $initialUpline)
            //     ->get();

            // $pairSourceId = null;
            // if ($initialChildren->count() >= 2) {
            //     $leftUser = $initialChildren->firstWhere('placement_position', 'left') ?? $initialChildren->firstWhere('placement_position', 'Left');
            //     $rightUser = $initialChildren->firstWhere('placement_position', 'right') ?? $initialChildren->firstWhere('placement_position', 'Right');
            //     if ($leftUser && $rightUser) {
            //         // Use the earliest-placed user in the pair as source_id
            //         $leftCreated = DB::table('networks')->where('user_id', $leftUser->user_id)->value('created_at');
            //         $rightCreated = DB::table('networks')->where('user_id', $rightUser->user_id)->value('created_at');
            //         $pairSourceId = ($leftCreated <= $rightCreated) ? $leftUser->user_id : $rightUser->user_id;
            //     }
            // }

            // $currentUpline = $upline_placement_id;
            // $maxTraversal = 1000; // safety to prevent infinite loop, adjust as needed
            // while ($currentUpline && $currentUpline != 0 && $maxTraversal-- > 0) {

            //     // Only proceed if we have a valid pair source_id
            //     if ($pairSourceId) {
            //         // Check if pairing bonus is already awarded for THIS pair to this upline
            //         $alreadyPaid = DB::table("referrals")
            //             ->where("user_id", $currentUpline)
            //             ->where("referral_type", "pairing_bonus")
            //             ->where("source_id", $pairSourceId)
            //             ->exists();

            //         if ($alreadyPaid) {
            //             \Log::info("Pair already paid for upline {$currentUpline} and pair source {$pairSourceId}");
            //         } else {
            //             // Get pairing amount from upline's package
            //             $package = DB::table('users')
            //                 ->join('packages', 'users.account_type', '=', 'packages.id')
            //                 ->select('packages.pairing_amount')
            //                 ->where('users.id', $currentUpline)
            //                 ->first();

            //             if (!$package) {
            //                 \Log::warning("No package found for upline {$currentUpline}, skipping pairing bonus.");
            //             } elseif ($package->pairing_amount <= 0) {
            //                 \Log::info("Pairing amount is zero for upline {$currentUpline}, skipping pairing bonus.");
            //             } else {
            //                 // Insert the sales match bonus
            //                 DB::table("referrals")->insert([
            //                     'user_id'       => $currentUpline,
            //                     'source_id'     => $pairSourceId,
            //                     'referral_type' => 'pairing_bonus',
            //                     'reward_type'   => 'php',
            //                     'hierarchy'     => 'upline',
            //                     'amount'        => $package->pairing_amount,
            //                     'status'        => 1,
            //                     'created_at'    => now(),
            //                     'updated_at'    => now(),
            //                 ]);

            //                 \Log::info("Sales match bonus awarded to Upline {$currentUpline} (Pair source {$pairSourceId}) amount={$package->pairing_amount}");
            //             }
            //         }
            //     }

            //     // Move to next upline (the upline of the current upline)
            //     $next = DB::table('networks')
            //         ->where('user_id', $currentUpline)
            //         ->value('upline_placement_id');

            //     // Defensive: stop if next equals current (cycle)
            //     if ($next == $currentUpline) {
            //         \Log::error("Cycle detected in network for user {$currentUpline}. Stopping traversal.");
            //         break;
            //     }

            //     $currentUpline = $next;
            // }
            //new
            $initialUpline = $upline_placement_id;
            $initialChildren = DB::table('networks')
                ->where('upline_placement_id', $initialUpline)
                ->get();

            $pairSourceId = null;
            if ($initialChildren->count() >= 2) {
                $leftUser = $initialChildren->firstWhere('placement_position', 'left') ?? $initialChildren->firstWhere('placement_position', 'Left');
                $rightUser = $initialChildren->firstWhere('placement_position', 'right') ?? $initialChildren->firstWhere('placement_position', 'Right');
                if ($leftUser && $rightUser) {
                    // Use the left user as source_id for direct pairing to avoid conflicts
                    $pairSourceId = $leftUser->user_id;
                }
            }

            $currentUpline = $upline_placement_id;
            $maxTraversal = 1000; // safety to prevent infinite loop, adjust as needed
            while ($currentUpline && $currentUpline != 0 && $maxTraversal-- > 0) {
                // Only proceed if we have a valid pair source_id
                if ($pairSourceId) {
                    // Check if pairing bonus is already awarded for THIS pair to this upline
                    $alreadyPaid = DB::table("referrals")
                        ->where("user_id", $currentUpline)
                        ->where("referral_type", "pairing_bonus")
                        ->where("source_id", $pairSourceId)
                        ->exists();

                    if ($alreadyPaid) {
                        \Log::info("Pair already paid for upline {$currentUpline} and pair source {$pairSourceId}");
                    } else {
                        // Get pairing amount from upline's package
                        $package = DB::table('users')
                            ->join('packages', 'users.account_type', '=', 'packages.id')
                            ->select('packages.pairing_amount')
                            ->where('users.id', $currentUpline)
                            ->first();

                        if (!$package) {
                            \Log::warning("No package found for upline {$currentUpline}, skipping pairing bonus.");
                        } elseif ($package->pairing_amount <= 0) {
                            \Log::info("Pairing amount is zero for upline {$currentUpline}, skipping pairing bonus.");
                        } else {
                            // Insert the sales match bonus
                            DB::table("referrals")->insert([
                                'user_id'       => $currentUpline,
                                'source_id'     => $pairSourceId,
                                'referral_type' => 'pairing_bonus',
                                'reward_type'   => 'php',
                                'hierarchy'     => 'upline',
                                'amount'        => $package->pairing_amount,
                                'status'        => 1,
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ]);

                            \Log::info("Sales match bonus awarded to Upline {$currentUpline} (Pair source {$pairSourceId}) amount={$package->pairing_amount}");
                        }
                    }
                }

                // Move to next upline (the upline of the current upline)
                $next = DB::table('networks')
                    ->where('user_id', $currentUpline)
                    ->value('upline_placement_id');

                // Defensive: stop if next equals current (cycle)
                if ($next == $currentUpline) {
                    \Log::error("Cycle detected in network for user {$currentUpline}. Stopping traversal.");
                    break;
                }

                $currentUpline = $next;
            }

            // ===========================================================
            // Outer Left and Outer Right Pairing Bonus
            // ===========================================================
            $currentUpline = $upline_placement_id;
            $maxTraversal = 1000; // Reset or reuse safety counter
            while ($currentUpline && $currentUpline != 0 && $maxTraversal-- > 0) {
                // Check if upline has both left and right children
                $children = DB::table('networks')
                    ->where('upline_placement_id', $currentUpline)
                    ->get();

                if ($children->count() >= 2) {
                    $leftChild = $children->firstWhere('placement_position', 'left') ?? $children->firstWhere('placement_position', 'Left');
                    $rightChild = $children->firstWhere('placement_position', 'right') ?? $children->firstWhere('placement_position', 'Right');

                    if ($leftChild && $rightChild) {
                        // Calculate depth of left and right subtrees
                        $leftDepth = $this->getSubtreeDepth($leftChild->user_id);
                        $rightDepth = $this->getSubtreeDepth($rightChild->user_id);

                        // Award outer pairing bonus only if depths are equal and greater than 0
                        if ($leftDepth > 0 && $rightDepth > 0 && $leftDepth == $rightDepth) {
                            // Get rightmost under right child as pair source_id to differentiate from direct pairing
                            $pairSourceId = $this->getOutermostUser($rightChild->user_id, 'right');

                            // Check if outer pairing bonus is already awarded for THIS pair to this upline
                            $alreadyPaid = DB::table("referrals")
                                ->where("user_id", $currentUpline)
                                ->where("referral_type", "pairing_bonus")
                                ->where("source_id", $pairSourceId)
                                ->exists();

                            if (!$alreadyPaid) {
                                // Get pairing amount from upline's package
                                $package = DB::table('users')
                                    ->join('packages', 'users.account_type', '=', 'packages.id')
                                    ->select('packages.pairing_amount')
                                    ->where('users.id', $currentUpline)
                                    ->first();

                                if (!$package) {
                                    \Log::warning("No package found for upline {$currentUpline}, skipping outer pairing bonus.");
                                } elseif ($package->pairing_amount <= 0) {
                                    \Log::info("Pairing amount is zero for upline {$currentUpline}, skipping outer pairing bonus.");
                                } else {
                                    // Insert the outer pairing bonus
                                    DB::table("referrals")->insert([
                                        'user_id'       => $currentUpline,
                                        'source_id'     => $pairSourceId,
                                        'referral_type' => 'pairing_bonus',
                                        'reward_type'   => 'php',
                                        'hierarchy'     => 'upline',
                                        'amount'        => $package->pairing_amount,
                                        'status'        => 1,
                                        'created_at'    => now(),
                                        'updated_at'    => now(),
                                    ]);

                                    \Log::info("Outer pairing bonus awarded to Upline {$currentUpline} (Pair source {$pairSourceId}) amount={$package->pairing_amount}");
                                }
                            }
                        }
                    }
                }

                // Move to next upline
                $next = DB::table('networks')
                    ->where('user_id', $currentUpline)
                    ->value('upline_placement_id');

                if ($next == $currentUpline) {
                    \Log::error("Cycle detected in network for user {$currentUpline}. Stopping traversal.");
                    break;
                }

                $currentUpline = $next;
            }
            //new end
            // ===========================================================
            // Pairing Bonus End
            // ===========================================================
            
            \Log::info("Update result: " . ($updateResult ? 'success' : 'failed'));
            $user->refresh();
            \Log::info("User sponsor_id after update: " . $user->sponsor_id);

            // If sponsor exists, calculate and award 15% referral commission
            if ($sponsor) {
                $commissionAmount = $this->calculateReferralCommission($application->member_type);
                if ($commissionAmount > 0) {
                    DB::table('referrals')->insert([
                        'user_id' => $sponsor->id,
                        'source_id' => $user_id,  // The newly approved user
                        'amount' => $commissionAmount,
                        'referral_type' => 'direct_referral_bonus',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    \Log::info("Referral bonus of {$commissionAmount} awarded to sponsor {$sponsor->id}");
                }
            }

            // Update application status
            DB::table('user_applications')
                ->where('user_id', $user_id)
                ->update([
                    'status' => 'approved',
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application approved successfully. User can now login with the set password.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getOutermostUser($user_id, $direction)
    {
        $direction = strtolower($direction); // Normalize to lowercase
        $current = $user_id;
        while (true) {
            $child = DB::table('networks')
                ->where('upline_placement_id', $current)
                ->where('placement_position', $direction)
                ->first();
            if (!$child) {
                return $current; // The leaf user_id
            }
            $current = $child->user_id;
        }
    }

    private function getSubtreeDepth($user_id)
    {
        $depth = 0;
        $queue = [$user_id];
        while (!empty($queue)) {
            $levelSize = count($queue);
            for ($i = 0; $i < $levelSize; $i++) {
                $current = array_shift($queue);
                $children = DB::table('networks')
                    ->where('upline_placement_id', $current)
                    ->pluck('user_id');
                $queue = array_merge($queue, $children->toArray());
            }
            $depth++;
        }
        return $depth - 1; // Subtract 1 because the root is depth 0, but we want the max depth
    }

    /**
     * Generate unique Sponsor ID based on member type and year
     * Format: SIREG2025001, SIMEG2025001, SIULT2025001
     * Ensures uniqueness with retry logic
     */
    private function generateSponsorId($memberType)
    {
        $year = date('Y');
        $prefixes = [
            'Regular' => 'SIREG',
            'REGULAR' => 'SIREG',
            'Mega' => 'SIMEG',
            'MEGA' => 'SIMEG',
            'Ultra' => 'SIULT',
            'ULTRA' => 'SIULT'
        ];

        $prefix = $prefixes[$memberType] ?? 'SI';
        $baseId = $prefix . $year;
        
        \Log::info("generateSponsorId: memberType={$memberType}, prefix={$prefix}, baseId={$baseId}");

        // Retry loop to ensure uniqueness in case of race conditions
        $maxRetries = 5;
        for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
            // Get the next sequence number from BOTH users table AND user_applications table
            // This ensures uniqueness even for pending applications
            $lastUserRecord = DB::table('users')
                ->where('sponsor_id', 'like', $baseId . '%')
                ->where('sponsor_id', '!=', null)
                ->orderByRaw('CAST(SUBSTRING(sponsor_id, -3) AS UNSIGNED) DESC')
                ->first();

            $lastApplicationRecord = DB::table('user_applications')
                ->where('sponsor_id', 'like', $baseId . '%')
                ->where('sponsor_id', '!=', null)
                ->orderByRaw('CAST(SUBSTRING(sponsor_id, -3) AS UNSIGNED) DESC')
                ->first();

            // Get the highest number from both tables
            $lastUserNumber = $lastUserRecord ? (int) substr($lastUserRecord->sponsor_id, -3) : 0;
            $lastAppNumber = $lastApplicationRecord ? (int) substr($lastApplicationRecord->sponsor_id, -3) : 0;
            $lastNumber = max($lastUserNumber, $lastAppNumber);

            if ($lastNumber > 0) {
                $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                \Log::info("Found existing ID, last number: {$lastNumber}, next number: {$nextNumber}");
            } else {
                $nextNumber = '001';
                \Log::info("No existing IDs found, starting with: 001");
            }

            $finalId = $baseId . $nextNumber;
            
            // Check if this ID already exists in BOTH tables
            $existsInUsers = DB::table('users')
                ->where('sponsor_id', $finalId)
                ->exists();
            
            $existsInApplications = DB::table('user_applications')
                ->where('sponsor_id', $finalId)
                ->exists();
            
            if (!$existsInUsers && !$existsInApplications) {
                \Log::info("Final Sponsor ID generated (unique): {$finalId}");
                return $finalId;
            }
            
            \Log::warning("Sponsor ID collision detected: {$finalId}, retrying...");
            sleep(1); // Small delay before retry
        }

        // If we get here, throw an exception
        throw new \Exception("Failed to generate unique sponsor ID after {$maxRetries} attempts");
    }

    /**
     * Calculate referral commission (15% of member type price from packages table)
     */
    private function calculateReferralCommission($memberType)
    {
        // Get the package price from packages table
        $package = DB::table('packages')
            ->where('type', $memberType)
            ->where('status', 1)
            ->first();
        
        if (!$package) {
            return 0;
        }

        return ($package->amount * 15) / 100;  // 15% commission
    }

    /**
     * Reject application
     */
    public function rejectApplication(Request $request, $user_id)
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Delete user
            $user = User::find($user_id);
            if ($user) {
                $user->delete();
            }

            // Update application status
            DB::table('user_applications')
                ->where('user_id', $user_id)
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->input('reason'),
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application rejected successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display listing of application codes
     */
    public function indexCodes()
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return redirect()->route('login');
        }

        $codes = \App\ApplicationCode::with('user.info')->orderBy('created_at', 'desc')->get();
        return view('admin.applications.codes', compact('codes'));
    }

    /**
     * Export application codes to CSV
     * @param string $type  'first10' | 'all'
     */
    public function exportCodes($type)
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return redirect()->route('login');
        }

        $query = \App\ApplicationCode::with('user.info')->orderBy('created_at', 'desc');

        if ($type === 'first10') {
            $codes = $query->limit(10)->get();
            $filename = 'product_codes_latest10_' . now()->format('Ymd_His') . '.csv';
        } else {
            $codes = $query->get();
            $filename = 'product_codes_all_' . now()->format('Ymd_His') . '.csv';
        }

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($codes) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, ['#', 'Product Code', 'Status', 'Used By', 'Created At', 'Used At']);

            foreach ($codes as $index => $code) {
                $usedBy = $code->user
                    ? (($code->user->info->first_name ?? '') . ' (' . $code->user->username . ')')
                    : '-';

                fputcsv($handle, [
                    $index + 1,
                    $code->code,
                    $code->is_used ? 'Used' : 'Available',
                    $usedBy,
                    $code->created_at->format('Y-m-d H:i:s'),
                    $code->is_used ? $code->updated_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate 10 new application codes
     */
    public function generateCodes()
    {
        if (!Auth::check() || !in_array(Auth::user()->userType, ['admin', 'staff'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $generated = 0;
        $codes = [];
        
        while ($generated < 10) {
            $codeStr = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Ensure uniqueness
            if (!\App\ApplicationCode::where('code', $codeStr)->exists()) {
                $codes[] = ['code' => $codeStr, 'created_at' => now(), 'updated_at' => now()];
                $generated++;
            }
        }

        \App\ApplicationCode::insert($codes);

        return redirect()->back()->with('success', '10 Product Codes generated successfully!');
    }

    private function getPlacementPosition($upline_id, $desired_position){
		$networks = DB::table('networks')->where('upline_placement_id',$upline_id)
		->where("sponsor_id", "!=", $upline_id)
		->get();
		$position = "";
		if(count($networks) == 0){
			$position = $desired_position;
		}else{
			$network_one = DB::table('networks')
                ->where('upline_placement_id',$upline_id)
				->where("sponsor_id", "!=", $upline_id)
                ->first();
            
			if($network_one->placement_position == 'left'){
				$position = "right";
			}else{
				$position = "left";
			}
			
		}
		return $position;
	}

}
