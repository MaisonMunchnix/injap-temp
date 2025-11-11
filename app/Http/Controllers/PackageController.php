<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
use App\Package;
use App\PackageProduct;
use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
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
    public function index(){
	   $packages = DB::table('packages')->where('status',1)->get();	
	   $sub_packages = DB::table('sub_packages')->where('status',1)->get();	
	   $products = DB::table('products')->where('category','!=',1)->where('status',1)->get();
	   $product_count = DB::table('products')->where('category','!=',1)->where('status',1)->count();

        return view('admin.packages.index', ['packages' => $packages, 'products' => $products, 'product_count' => $product_count]);
    }
    
    public function index_dev(){
	   $packages = DB::table('packages')->where('status',1)->get();	
	   $products = DB::table('products')->where('category','!=',1)->where('status',1)->get();
	   $product_count = DB::table('products')->where('category','!=',1)->where('status',1)->count();

        return view('admin.packages-dev.index', ['packages' => $packages, 'products' => $products, 'product_count' => $product_count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!is_dir(public_path('assets/img/product'))) {
            mkdir(public_path('assets/img/product'), 0777);
        }
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        $request->image->move(public_path('assets/img/product/'), $imageName);

        $description = $request->input('description');
        $type = $request->input('type');
        $amount = $request->input('amount');
        $referral_amount = $request->input('referral_amount');
        $pv_points = $request->input('pv_points');
        $account_discount = $request->input('account_discount');
		$discount = str_replace('%', '', $account_discount) / 100.00;
		$products = $request->input('select_product');
		$quantities = $request->input('product_qty');

		DB::beginTransaction();
		try {
			$package = new Package();
			$package->type = $type;
			$package->amount = $amount;
			$package->referral_amount = $referral_amount;
			$package->pv_points = $pv_points;
			$package->account_discount = $discount;
			$package->save();
            
            //Save also to products
            $product = new Product();
			$product->category = 1;
			$product->package_id = $package->id;
			$product->description = $description;
			$product->image = 'assets/img/product/' . $imageName;
			$product->name = $package->type;
			$product->code = "$type-$amount";
			$product->price = $package->amount;
			$product->unilevel_price = 0;
			$product->rating = 5;
			$product->status = 1;
			$product->quantity= 0;
			$product->critical_level= 0;
			$product->discount=0;
			$product->save();

			if(!empty($products)){
				for($count = 0; count($products) > $count; $count++){
					$data = array(
						'package_id' => $package->id,
						'product_id' => $products[$count],
						'quantity' => $quantities[$count],
						'created_by' => Auth::id()
                	);
					$insert_data[] = $data; 
        		}
				PackageProduct::insert($insert_data);
			}
			// Insert User Log
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 18; // Description ID
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			
			DB::commit();
			return response()->json();
		
		}catch(\Throwable $e){
			DB::rollback();
			
			// Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 18; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */ 
   // Get Package Datas
    public function editPackage(Request $request){
        $id = $request['id'];
        $package = Package::where('id',$id)->first();
        $sub_packages = DB::table('sub_packages')->where('package_id',$id)->get();
        $product = Product::where('package_id', $id)->first();
        $package_product = PackageProduct::where('package_id',$id)->get();
        $products = DB::table('products')->where('category','!=',1)->where('status',1)->get();
        return response()->json([
            'package' => $package,
            'sub_packages' => $sub_packages,
            'product' => $product,
            'package_product' => $package_product,
            'products' => $products
        ]);
   }
    
    // Get Package Datas
    public function editPackage_dev(Request $request){
        $id = $request['id'];
        $package = Package::where('id',$id)->first();
        $package_product = PackageProduct::where('package_id',$id)->get();
        $products = DB::table('products')->where('category','!=',1)->where('status',1)->get();
        return response()->json([
            'package' => $package,
            'package_product' => $package_product,
            'products' => $products
        ]);
   }
	
	public function edit(Request $request){
		$id = $request['id'];
		$package = Package::find($id);
        //$product_categories = DB::table('product_categories')->first();
        return response()->json($package);
    }
	

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    //Update Product
	public function updatePackage(Request $request){
		DB::beginTransaction();
		try {


        	$package=Package::find($request['id']);
            $product=Product::where('package_id', $request['id'])->first();
			$account_discount = $request->input('account_discount');
            $discount = str_replace('%', '', $account_discount) / 100.00;
            
			$package->type = $request['type'];
			$package->amount = $request['amount'];
			$package->referral_amount = $request['referral_amount'];
			$package->pv_points = $request['pv_points'];
			$package->account_discount = number_format($discount,2);
            $package->update();
            
            //Update also to products
            $product = Product::where('package_id',$request['id'])->first();
            $imageName=$product->image;
            if($request->has('image')) {
                if (!is_dir(public_path('assets/img/product'))) {
                    mkdir(public_path('assets/img/product'), 0777);
                }
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
                ]);
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/img/product/'), $imageName);
                $imageName = 'assets/img/product/' . $imageName;
            }
            if(!empty($product)){
                $product->name = $request['type'];
                $product->description = $request['description'];
                $product->price = $request['amount'];
                $product->code = $request['type'];
                $product->image = $imageName;
                $product->update();
            } else {
                //Save also to products
                $new_product = new Product();
                $new_product->category = 1;
                $new_product->package_id = $package->id;
                $new_product->description = $request['description'];
                $new_product->name = $request['type'];
                $new_product->code = $package->type . "-" . $package->amount;
                $new_product->price = $package->amount;
                $new_product->image = $imageName;
                $new_product->save();
            }
			
            
            
            
            $products = $request->get('select_product');
            $quantities = $request->get('product_qty'); 
            if(!empty($products)){
				for($count = 0; count($products) > $count; $count++){
                    $package_product = PackageProduct::where('product_id',$products[$count])->first();
                    if($package_product){
                        $package_product->package_id = $package->id;
                        $package_product->product_id = $products[$count];
                        $package_product->quantity = $quantities[$count];
                        $package_product->created_by = Auth::id();
                        $package_product->update();
                        
                        $product_delete=PackageProduct::where('package_id',$package->id)->where('product_id','!=',$products[$count])->delete();
                    } else {
                        /*$data = array(
						  'package_id' => $package->id,
						  'product_id' => $products[$count],
						  'quantity' => $quantities[$count],
						  'created_by' => Auth::id()
                	   );
                        $insert_data[] = $data;*/
                        
                        $package_product =  new PackageProduct();
                        $package_product->package_id = $package->id;
                        $package_product->product_id = $products[$count];
                        $package_product->quantity = $quantities[$count];
                        $package_product->created_by = Auth::id();
                        $package_product->save();
                       
                    }
                    //if($data){ PackageProduct::insert($insert_data); }
        		}
                 
			} else {
                $package_product=PackageProduct::where('package_id',$package->id)->delete();
            }
			
			// Insert User Log
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 20; // Description ID
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			
			DB::commit();
			
			return response()->json();
		
		}catch(\Throwable $e){
			DB::rollback();
			
			// Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 20; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
	
	//Package Delete
	public function destroy(Request $request){
		DB::beginTransaction();
		try {
			$id = $request['id'];
			$package = Package::find($id);
			$package->status = 2;
			$package->save();
            
            $product=Product::where('package_id',$id)->first();
			$product->status = 2;
			$product->save();
			
			$package_product = PackageProduct::where('package_id', $id)->first();
            if($package_product){
                $package_product->status = 2;
                $package_product->save();
            }
			
			
			DB::commit();
			return response()->json();
		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
	}
}
