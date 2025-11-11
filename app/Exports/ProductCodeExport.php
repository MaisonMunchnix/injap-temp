<?php
namespace App\Exports;
use App\Encashment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class ProductCodeExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    
    public function collection()
    {
        $product_codes = DB::table('product_codes')
            ->join('products', 'product_codes.product_id','=','products.id')
            ->select('product_codes.code','product_codes.security_pin', 'products.name')
            ->where('sale_id', $this->id)
            ->get();
        
        return $product_codes;
    }
    
    public function headings(): array
    {
        return [
            'Product Code',
            'Security PIN',
            'Package'
        ];
    }
}