<?php

namespace App\Http\Controllers;

use App\User;
use App\Referral;
use App\IncomeTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransferController extends Controller
{
    /**
     * Validate if sponsor ID exists
     */
    public function validateUserId($sponsorId)
    {
        if (!$sponsorId) {
            return response()->json([
                'success' => false,
                'exists' => false,
                'message' => 'Sponsor ID is required'
            ], 400);
        }

        // Search by sponsor_id field (alphanumeric code like SIREG2025027)
        $user = User::where('sponsor_id', $sponsorId)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'exists' => false,
                'message' => 'Sponsor ID does not exist'
            ], 404);
        }

        // Check if account is active (status = 1 or 'active')
        if ($user->status != 1 && $user->status != 'active') {
            return response()->json([
                'success' => false,
                'exists' => true,
                'message' => 'This account is inactive'
            ], 422);
        }

        $fullName = $user->username;
        if ($user->info) {
            $firstName = $user->info->first_name ?? '';
            $lastName = $user->info->last_name ?? '';
            $fullName = trim($firstName . ' ' . $lastName) ?: $user->username;
        }

        return response()->json([
            'success' => true,
            'exists' => true,
            'full_name' => $fullName,
            'message' => 'Sponsor ID is valid'
        ], 200);
    }

    /**
     * Validate if username exists
     */
    public function validateUsername($username)
    {
        if (!$username) {
            return response()->json([
                'success' => false,
                'exists' => false,
                'message' => 'Username is required'
            ], 400);
        }

        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'exists' => false,
                'message' => 'Username does not exist'
            ], 404);
        }

        // Check if account is active (status = 1 or 'active')
        if ($user->status != 1 && $user->status != 'active') {
            return response()->json([
                'success' => false,
                'exists' => true,
                'message' => 'This account is inactive'
            ], 422);
        }

        $fullName = $user->username;
        if ($user->info) {
            $firstName = $user->info->first_name ?? '';
            $lastName = $user->info->last_name ?? '';
            $fullName = trim($firstName . ' ' . $lastName) ?: $user->username;
        }

        return response()->json([
            'success' => true,
            'exists' => true,
            'full_name' => $fullName,
            'message' => 'Username is valid'
        ], 200);
    }

    /**
     * Transfer social funds from one member to another
     */
    public function transferFunds(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'fund_source' => 'required|in:social_funds,charity_funds,other_funds',
            'recipient_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string|max:500'
        ]);

        $sender = Auth::user();
        $fundSource = $validated['fund_source'];
        $recipientSponsorId = $validated['recipient_id'];
        $amount = floatval($validated['amount']);
        $reason = $validated['reason'] ?? '';

        // Check if sender is authenticated
        if (!$sender) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Find recipient by sponsor_id
        $recipient = User::where('sponsor_id', $recipientSponsorId)->first();

        if (!$recipient) {
            return response()->json([
                'success' => false,
                'message' => 'Recipient not found. Please check the sponsor ID.'
            ], 404);
        }

        // Check if sender and recipient are the same
        if ($sender->id === $recipient->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot transfer funds to yourself.'
            ], 422);
        }

        // Check recipient account status
        if ($recipient->status != 1 && $recipient->status != 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Recipient account is not active.'
            ], 422);
        }

        // Get sender's balance for the selected fund source
        $senderBalance = $this->getFundBalance($sender, $fundSource);

        if ($amount > $senderBalance) {
            $fundLabel = $this->getFundLabel($fundSource);
            return response()->json([
                'success' => false,
                'message' => 'Insufficient ' . $fundLabel . '. Your available balance is: ' . number_format($senderBalance, 2) . ' ¥'
            ], 422);
        }

        // Use database transaction to ensure data integrity
        try {
            DB::beginTransaction();

            // Deduct from sender's specified fund source (pass recipient sponsor ID)
            $senderReferral = $this->deductFromSender($sender, $amount, $fundSource, $reason, $recipient->sponsor_id);

            // Add to recipient in the same fund type (pass sender sponsor ID)
            $recipientReferral = $this->addToRecipient($recipient, $amount, $fundSource, $reason, $sender->sponsor_id);

            DB::commit();

            // Use sender's referral ID as transaction ID
            $transactionId = $senderReferral->id ?? $recipientReferral->id ?? uniqid('TXN');

            return response()->json([
                'success' => true,
                'message' => 'Funds transferred successfully!',
                'transaction_id' => $transactionId,
                'new_balance' => $this->getFundBalance($sender, $fundSource)
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Transfer failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get balance for a specific fund type
     */
    private function getFundBalance($user, $fundType)
    {
        $referrals = Referral::where('user_id', $user->id)->get();
        
        switch ($fundType) {
            case 'social_funds':
                // Direct Referral Bonus
                return $referrals
                    ->where('referral_type', 'direct_referral_bonus')
                    ->sum('amount');
            
            case 'charity_funds':
                // Pairing Bonus
                return $referrals
                    ->where('referral_type', 'pairing_bonus')
                    ->sum('amount');
            
            case 'other_funds':
                // Manual adjustments net balance
                $totalAdded = $referrals
                    ->where('referral_type', 'manual_adjustment')
                    ->where('amount', '>', 0)
                    ->sum('amount');
                
                $totalDeducted = $referrals
                    ->where('referral_type', 'manual_adjustment')
                    ->where('amount', '<', 0)
                    ->sum('amount');
                
                return $totalAdded + $totalDeducted; // totalDeducted is negative
            
            default:
                return 0;
        }
    }

    /**
     * Get label for fund type
     */
    private function getFundLabel($fundType)
    {
        $labels = [
            'social_funds' => 'Social Funds',
            'charity_funds' => 'Charity Funds',
            'other_funds' => 'Other Funds'
        ];
        
        return $labels[$fundType] ?? 'Funds';
    }

    /**
     * Get sender's available balance (Other Funds)
     * Based on manual_adjustment referrals
     */
    private function getSenderBalance($user)
    {
        // Get balance from referrals table - Other Funds (manual_adjustment type)
        $referrals = Referral::where('user_id', $user->id)->get();
        
        $totalAddedIncome = $referrals
            ->where('referral_type', 'manual_adjustment')
            ->where('amount', '>', 0)
            ->sum('amount');
        
        $totalDeductions = $referrals
            ->where('referral_type', 'manual_adjustment')
            ->where('amount', '<', 0)
            ->sum('amount');
        
        $balance = $totalAddedIncome + $totalDeductions; // totalDeductions is negative
        
        return max(0, floatval($balance)); // Return 0 if negative
    }

    /**
     * Deduct amount from sender's selected fund source
     */
    private function deductFromSender($user, $amount, $fundSource, $reason = '', $recipientSponsorId = '')
    {
        // Determine referral type based on fund source
        $referralType = 'manual_adjustment';
        $remarks = 'Fund transfer deduction';
        
        switch ($fundSource) {
            case 'social_funds':
                $referralType = 'direct_referral_bonus';
                $remarks = 'Fund transfer deduction - Social Funds';
                break;
            case 'charity_funds':
                $referralType = 'pairing_bonus';
                $remarks = 'Fund transfer deduction - Charity Funds';
                break;
            case 'other_funds':
                $referralType = 'manual_adjustment';
                $remarks = 'Fund transfer deduction - Other Funds';
                break;
        }
        
        // Add recipient sponsor ID and reason if provided
        if ($recipientSponsorId) {
            $remarks .= ' | To: ' . $recipientSponsorId;
        }
        if ($reason) {
            $remarks .= ' | Reason: ' . $reason;
        }
        
        // Create a negative referral record for deduction
        $referral = new Referral();
        $referral->user_id = $user->id;
        $referral->source_id = $user->id;
        $referral->amount = -$amount; // Negative for deduction
        $referral->referral_type = $referralType;
        $referral->reward_type = 'php';
        $referral->hierarchy = 0;
        $referral->status = 1;
        $referral->remarks = $remarks;
        $referral->save();
        
        return $referral;
    }

    /**
     * Add amount to recipient in the same fund type as transferred
     */
    private function addToRecipient($user, $amount, $fundSource, $reason = '', $senderSponsorId = '')
    {
        // Determine referral type based on fund source
        $referralType = 'manual_adjustment';
        $remarks = 'Fund transfer received';
        
        switch ($fundSource) {
            case 'social_funds':
                $referralType = 'direct_referral_bonus';
                $remarks = 'Fund transfer received - Social Funds';
                break;
            case 'charity_funds':
                $referralType = 'pairing_bonus';
                $remarks = 'Fund transfer received - Charity Funds';
                break;
            case 'other_funds':
                $referralType = 'manual_adjustment';
                $remarks = 'Fund transfer received - Other Funds';
                break;
        }
        
        // Add sender sponsor ID and reason if provided
        if ($senderSponsorId) {
            $remarks .= ' | From: ' . $senderSponsorId;
        }
        if ($reason) {
            $remarks .= ' | Reason: ' . $reason;
        }
        
        // Create a positive referral record for addition
        $referral = new Referral();
        $referral->user_id = $user->id;
        $referral->source_id = $user->id;
        $referral->amount = $amount; // Positive for addition
        $referral->referral_type = $referralType;
        $referral->reward_type = 'php';
        $referral->hierarchy = 0;
        $referral->status = 1;
        $referral->remarks = $remarks;
        $referral->save();
        
        return $referral;
    }

    /**
     * Get transfer history for authenticated user
     */
    public function getTransferHistory(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);

        // Get both sent and received transfers
        $transfers = IncomeTransfer::where(function ($query) use ($user) {
            $query->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id);
        })
        ->with(['sender' => function ($query) {
            $query->select('id', 'username', 'first_name', 'last_name');
        }, 'recipient' => function ($query) {
            $query->select('id', 'username', 'first_name', 'last_name');
        }])
        ->where('type', 'social_fund_transfer')
        ->orderBy('transaction_date', 'desc')
        ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $transfers
        ], 200);
    }
}
