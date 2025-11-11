<?php

namespace App\Http\Controllers;

use App\ProductCode;
use App\User;
use PDF;
use Alert;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Barryvdh\DomPDF\Facade;


class ProductCodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $search = $request->get('search', '');

        if ($type == 'members') {
            $product_codes = DB::table('product_codes')
                ->leftJoin('packages', 'product_codes.category', '=', 'packages.id')
                ->leftJoin('users', 'product_codes.user_id', '=', 'users.id')
                ->leftJoin('user_infos', 'product_codes.user_id', '=', 'user_infos.user_id')
                ->leftJoin('products', 'product_codes.product_id', '=', 'products.id')
                ->leftJoin('payments', 'product_codes.sale_id', '=', 'payments.sale_id')
                ->select(
                    DB::raw("payments.confirmation_number AS receipt_number, product_codes.code AS code, product_codes.security_pin AS security_pin, packages.type AS type, products.name AS product_name, users.username AS username, CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS fullname, product_codes.created_at AS created_at")
                )
                ->where('product_codes.status', 1)
                ->where(function ($query) use ($search) {
                    $query->where('product_codes.code', 'like', '%' . $search . '%')
                        ->orWhere('users.username', 'like', '%' . $search . '%');
                })
                ->simplePaginate(25);

            $queryParameters = $request->except('_token');

            $product_codes->appends($queryParameters);

            return view('admin.sales-reports.product-codes', compact('product_codes', 'search'));
        } elseif ($type == 'non-members') {
            return view('admin.sales-reports.nonmember-product-codes');
        }
    }

	
	public function membersCode(Request $request){
        $columns = array( 
            0 => 'receipt_number',
            1 => 'code',
            2 => 'security_pin',
            3 => 'username',
            4 => 'fullname',
            5 => 'type',
            6 => 'created_at'
        );

            $totalData = 0;
		
            
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
            $product_codes = DB::table('product_codes')
                ->leftJoin('packages', 'product_codes.category', '=', 'packages.id')
                ->leftJoin('users', 'product_codes.user_id', '=', 'users.id')
                ->leftJoin('user_infos', 'product_codes.user_id', '=', 'user_infos.user_id')
                ->leftJoin('products', 'product_codes.product_id', '=', 'products.id')
                ->leftJoin('payments', 'product_codes.sale_id', '=', 'payments.sale_id')
                ->select(DB::raw("payments.confirmation_number AS receipt_number, product_codes.code AS code, product_codes.security_pin AS security_pin,packages.type AS type, products.name AS product_name, users.username AS username,concat(`user_infos`.`first_name`,`user_infos`.`last_name`) AS `fullname`,product_codes.created_at AS created_at"))
                ->where('product_codes.status',1)
                ->simplePaginate(10);
        } else {
            $search = $request->input('search.value'); 

            $product_codes = DB::table('codes_view')
                ->where('username','!=',NULL)
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('username', 'LIKE',"%{$search}%")
                ->orWhere('fullname', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DB::table('codes_view')
                ->where('username','!=',NULL)
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('username', 'LIKE',"%{$search}%")
                ->orWhere('fullname', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->count();

        }

        $data = array();
        //$username = $full_name = "N/A";
        if(!empty($product_codes))
        {
            foreach ($product_codes as $product_code)
            {
                
                if($product_code->type == 'gold'){
                    $type = "<span class='badge badge-warning'>$product_code->type</span>";
                } else if($product_code->type == 'silver') {
                    $type = "<span class='badge badge-light'>$product_code->type</span>";
                } else if(empty($product_code->type)){
                    $type = "<span class='badge badge-info'>$product_code->product_name</span>";
                } else {
                    $type = "<span class='badge badge-danger'>$product_code->type</span>";
                }
                
                
                if($product_code->receipt_number == NULL){
                    $receipt_no = "N/A";
                } else {
                    $receipt_no = $product_code->receipt_number;
                }
                
                
                $nestedData['receipt_no'] = $receipt_no;
                $nestedData['code'] = $product_code->code;
                $nestedData['security_pin'] = $product_code->security_pin;
                $nestedData['username'] = $product_code->username;
                $nestedData['fullname'] = ucwords($product_code->fullname);
                $nestedData['type'] = ucfirst($type);
                $nestedData['created_at'] = $product_code->created_at;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

    public function membersCodeOLD(Request $request){
        $columns = array( 
            0 => 'receipt_number',
            1 => 'code',
            2 => 'security_pin',
            3 => 'username',
            4 => 'fullname',
            5 => 'type',
            6 => 'created_at'
        );

  
        $totalData = DB::table('codes_view')
                ->where('username','!=',NULL)
				->count();
		
            
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
            $product_codes = DB::table('codes_view')
                ->where('username','!=',NULL)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        } else {
            $search = $request->input('search.value'); 

            $product_codes = DB::table('codes_view')
                ->where('username','!=',NULL)
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('username', 'LIKE',"%{$search}%")
                ->orWhere('fullname', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DB::table('codes_view')
                ->where('username','!=',NULL)
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('username', 'LIKE',"%{$search}%")
                ->orWhere('fullname', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->count();

        }

        $data = array();
        //$username = $full_name = "N/A";
        if(!empty($product_codes))
        {
            foreach ($product_codes as $product_code)
            {
                
                if($product_code->type == 'gold'){
                    $type = "<span class='badge badge-warning'>$product_code->type</span>";
                } else if($product_code->type == 'silver') {
                    $type = "<span class='badge badge-light'>$product_code->type</span>";
                } else if(empty($product_code->type)){
                    $type = "<span class='badge badge-info'>$product_code->product_name</span>";
                } else {
                    $type = "<span class='badge badge-danger'>$product_code->type</span>";
                }
                
                
                if($product_code->receipt_number == NULL){
                    $receipt_no = "N/A";
                } else {
                    $receipt_no = $product_code->receipt_number;
                }
                
                
                $nestedData['receipt_no'] = $receipt_no;
                $nestedData['code'] = $product_code->code;
                $nestedData['security_pin'] = $product_code->security_pin;
                $nestedData['username'] = $product_code->username;
                $nestedData['fullname'] = ucwords($product_code->fullname);
                $nestedData['type'] = ucfirst($type);
                $nestedData['created_at'] = $product_code->created_at;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    

    public function nonmembersCode(Request $request){
        $columns = array( 
            0 => 'id',
            1 => 'receipt_number',
            2 => 'code',
            3 => 'security_pin',
            4 => 'type',
            5 => 'created_at'
        );

  
        $totalData = DB::table('nonmemers_codes_view')
				->count();
		
            
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
            $product_codes = DB::table('nonmemers_codes_view')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        } else {
            $search = $request->input('search.value'); 

            $product_codes = DB::table('nonmemers_codes_view')
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DB::table('nonmemers_codes_view')
                ->orWhere('receipt_number', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('security_pin', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('product_name', 'LIKE',"%{$search}%")
                ->count();

        }

        $data = array();
        //$username = $full_name = "N/A";
        if(!empty($product_codes)) {
            foreach ($product_codes as $product_code) {
                if($product_code->type == 'gold'){
                    $type = "<span class='badge badge-warning'>$product_code->type</span>";
                } else if($product_code->type == 'silver') {
                    $type = "<span class='badge badge-light'>$product_code->type</span>";
                } else if(empty($product_code->type)){
                    $type = "<span class='badge badge-info'>$product_code->product_name</span>";
                } else {
                    $type = "<span class='badge badge-danger'>$product_code->type</span>";
                }
                
                
                if($product_code->receipt_number == NULL){
                    $receipt_no = "N/A";
                } else {
                    $receipt_no = $product_code->receipt_number;
                }
                
                $nestedData['id'] = $product_code->id;
                $nestedData['receipt_no'] = $receipt_no;
                $nestedData['code'] = $product_code->code;
                $nestedData['security_pin'] = $product_code->security_pin;
                $nestedData['type'] = ucfirst($type);
                $nestedData['created_at'] = $product_code->created_at;
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	
	//Product Codes Today
    public function productCodesToday()
    {
		
		$date_now = date('Y-m-d');
		$product_codes = DB::table('product_codes')
			->join('packages', 'product_codes.category', '=', 'packages.id')
			->select('product_codes.*', 'packages.type')
			->where('product_codes.created_at','>=',Carbon::today())
			->where('status',0)
			->get();
        return view('TellerSystem.product_code.generate_codes', ['product_codes' => $product_codes]);
    }
	
	//Search username in generate code
	public function search(Request $request){
    	$users = User::where('username', 'LIKE', '%'.$request->input('term', '').'%')
        	->where('status',1)
        	->where('userType','user')
        	->get(['id', 'username as text']);
    	return ['results' => $users];
	}
	
	//New 01-21-2020
	//generate FORM
	 public function generate_code(){
		
		$date_now = date('Y-m-d');
		$product_codes = DB::table('product_codes')->where('created_at','>=',Carbon::today())->where('status',0)->get();
		$packages = DB::table('packages')->get();
		$users = DB::table('users')
			->join('user_infos', 'users.id', '=', 'user_infos.user_id')
			->select('users.id', 'users.username', 'user_infos.first_name', 'user_infos.last_name')
			->where('users.status',1)
			->where('users.userType','user')->get();
        return view('TellerSystem.product_code.generate', ['product_codes' => $product_codes, 'users' => $users, 'packages' => $packages]);
    }
	
	//New 01-21-2020 
	//Generate Code
	public function generate_code_insert(Request $request){
		
		$total = 0;
		function sernum(){
			$template = 'XX99-XX99-99XX-99XX-XXXX-99XX';
			$k = strlen($template);
			$sernum = '';
			for ($i=0; $i<$k; $i++)
			{
				switch($template[$i])
				{
					case 'X': $sernum .= chr(rand(65,90)); break;
					case '9': $sernum .= rand(0,9); break;
					case '-': $sernum .= '-';  break; 
				}
			}
			return $sernum;
		}
		
		function secpin(){
			$secpin = sprintf("%06d", mt_rand(1, 999999));
			return $secpin;
		}
		
		$username = $request->input('username');
		$packages = DB::table('packages')->get();
		
		foreach ($packages as $package) {
			$type = "$" . $package->type . "_qty";
			$qty = $request->input($package->type . "_qty");
			if($type){
				for($i=1;$i<=$qty;$i++){
					$product_codes = ProductCode::where('code',sernum())->get();
					if($product_codes->isEmpty()) {
						$product_code = new ProductCode();
						$product_code->sponsor_id = $username;
						$product_code->category = $package->id;
						$product_code->code = sernum();
						$product_code->security_pin = secpin();
						$product_code->save();	
					}
					
				}
			} else {
				 return response()->json(['error'=> 'No Record!']);
			}
			$total = $total + $qty;
		}
		$last_inserted_product_id = $product_code->id;
		$first_id = $last_inserted_product_id - $total + 1;
		
		$generated_product_codes = DB::table('product_codes')
            		->join('packages', 'product_codes.category', '=', 'packages.id')
            		->select('product_codes.code','product_codes.security_pin', 'packages.type')
					->where('product_codes.sponsor_id',$username)
					->whereBetween('product_codes.id',[$first_id,$last_inserted_product_id])
					//->whereBetween('product_codes.id','<=',$last_inserted_product_id)
            		->get();
				
		Session::flash('product_codes',$generated_product_codes); 
		
		 return response()->json(['success'=> $total . ' Generated Successfully']);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request){
		
		function sernum(){
			$template = 'XX99-XX99-99XX-99XX-XXXX-99XX';
			$k = strlen($template);
			$sernum = '';
			for ($i=0; $i<$k; $i++)
			{
				switch($template[$i])
				{
					case 'X': $sernum .= chr(rand(65,90)); break;
					case '9': $sernum .= rand(0,9); break;
					case '-': $sernum .= '-';  break; 
				}
			}
			return $sernum;
		}
		
		$number_generate = $request->input('number_generate');
		
		for($i=1;$i<=$number_generate;$i++){
			$license = sernum();
			$security_pin = sprintf("%06d", mt_rand(1, 999999));
			$product_codes = ProductCode::where('code',$license)->get();
			if($product_codes->isEmpty()) {
				$product_code = new ProductCode();
				$product_code->code = $license;
				$product_code->security_pin = $security_pin;
				$product_code->save();	
			}

		}
		$request->session()->flash('successMsg', $number_generate . ' Generated succesfully!');
		return redirect()->to('/teller-admin/generate_codes');
    }
	
	public function print(Request $request){
		
		$date = date('m-d-Y his');
		
		$checkboxes = $request->get('checkbox');
		
		if($checkboxes){
			$product_codes = DB::table('product_codes')->where('created_at', '>=', Carbon::today())->whereIn('id',$checkboxes)->where('status',0)->get();
		} else {
			$product_codes = DB::table('product_codes')->where('created_at', '>=', Carbon::today())->where('status',0)->get();
		}
		
		// Send data to the view using loadView function of PDF facade
		$pdf = PDF::loadView('TellerSystem.product_code.generate_pdf2', ['product_codes' => $product_codes]);
		// If you want to store the generated pdf to the server then you can use the store function
		$pdf->save(storage_path('codes/').$date . '_product-codes.pdf');
		// Finally, you can download the file using download function
		
		return $pdf->download('product-codes_' . $date . '.pdf');
    }
	
	public function print2(Request $request){
		
		$date = date('m-d-Y his');
		
		$checkboxes = $request->get('checkbox');
		
		if($checkboxes){
			$product_codes = DB::table('product_codes')->whereIn('id',$checkboxes)->where('status',0)->get();
		} else {
			$product_codes = DB::table('product_codes')->where('status',0)->get();
		}
		
		// Send data to the view using loadView function of PDF facade
		$pdf = PDF::loadView('TellerSystem.product_code.generate_pdf2', ['product_codes' => $product_codes]);
		// If you want to store the generated pdf to the server then you can use the store function
		$pdf->save(storage_path('codes/').$date . '_product-codes.pdf');
		// Finally, you can download the file using download function
		
		return $pdf->download('product-codes_' . $date . '.pdf');
    }
	
	public function export_pdf(){
		$date = date('m-d-Y');
		
		// Fetch all customers from database
		$product_codes = DB::table('product_codes')->get();
		// Send data to the view using loadView function of PDF facade
		$pdf = PDF::loadView('TellerSystem.generate_pdf', ['product_codes' => $product_codes]);
		// If you want to store the generated pdf to the server then you can use the store function
		$pdf->save(storage_path().$date . '_product-codes.pdf');
		// Finally, you can download the file using download function
		
		return $pdf->download($date . '_product-codes.pdf');
  }

	public function store(Request $request){
		

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCode $productCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCode $productCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCode $productCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
		DB::table("product_codes")->delete($id);
		/*ProductCode::find($id)->delete($id);*/
  
		Alert::alert('Title', 'Message', 'Type');
        return redirect()->to('/teller-admin/generate_codes');
    	/*return response()->json([
			'success' => 'Record deleted successfully!'
		]);*/
    }
}
