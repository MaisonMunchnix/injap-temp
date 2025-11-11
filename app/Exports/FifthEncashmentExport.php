<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class FifthEncashmentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $datecreate_start;
    protected $datecreate_end;
    public function __construct($datecreate_start,$datecreate_end)
    {
        $this->date_start = $datecreate_start;
        $this->date_end = $datecreate_end;
    }
    
    public function collection()
    {
        $date_start = $this->date_start;
        $date_end = $this->date_end;
        return DB::table('fifth_encashments_view')
            ->select('encash_created','username','member_lname','member_fname','amt_req','amt_appr',DB::raw('amt_appr AS net_pay'))
            //->whereBetween('encash_created', [$date_start, $date_end])
            ->whereBetween('encash_created', array($date_start . ' 00:00:00', $date_end . ' 23:59:59'))
            ->where('encash_status','claimed')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'Date Rquested',
            'Username',
            'Last Name',
            'First Name',
            'Amount Requested',
            'Amount Approved',
            'Net Pay'
        ];
    }
}