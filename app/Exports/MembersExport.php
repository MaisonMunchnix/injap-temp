<?php
namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MembersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = User::select(
            'users.id as user_id',
            'users.plain_password as plain_pass',
            'users.sponsor_id as sponsor_id',
            'users.username',
            'user_infos.first_name',
            'users.email',
            'user_infos.country_name',
            'users.member_type as package',
            'users.status as status',
            'users.created_at as created_at',
            DB::raw("COALESCE(upline_sponsor.username, 'N/A') as sponsor")
        )
        ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('networks', 'users.id', '=', 'networks.user_id')
        ->leftJoin('users as upline_sponsor', 'networks.sponsor_id', '=', 'upline_sponsor.id')
        ->where('users.userType', 'user')
        ->groupBy("users.id");

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('user_infos.first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('users.email', 'like', '%' . $this->search . '%')
                  ->orWhere('users.username', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->get();

        // Add total income for each user
        return $users->map(function ($user) {
            $user->total_income = $this->calculateUserTotalIncome($user->user_id);
            return $user;
        });
    }

    public function headings(): array
    {
        return [
            'Username',
            'Password',
            'Sponsor ID',
            'User ID',
            'First Name',
            'Email',
            'Country',
            'Package',
            'Status',
            'Date Created',
            'Upline Sponsor',
            'Total Income'
        ];
    }

    private function calculateUserTotalIncome($userId)
    {
        $total_accumulated = 0;

        // Base referrals (excluding sales_match_bonus)
        $referrals = DB::table('referrals')
            ->where('user_id', $userId)
            ->where('reward_type', 'php')
            ->where('referral_type', '!=', 'sales_match_bonus')
            ->sum('amount');
        
        $total_accumulated += $referrals;

        // Add pairing bonus
        try {
            $pairingComputation = \App\PairingComputation::where('user_id', $userId)->first();
            if ($pairingComputation) {
                $TPBunos = $pairingComputation->pairing_bonus ?? 0;
                $total_accumulated += $TPBunos;
            }
        } catch (\Exception $e) {
            // Table doesn't exist or other error, continue without pairing bonus
        }

        return $total_accumulated;
    }
}
