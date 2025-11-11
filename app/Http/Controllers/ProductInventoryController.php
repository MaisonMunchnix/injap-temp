<?php

namespace App\Http\Controllers;
use Auth;
use App\Product;
use App\ProductInventory;
use App\ProductCategory;
use App\UserLog;
use App\Branch;
use App\ProductTransaction;
use App\ProductTransactionInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductInventoryController extends Controller
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
		$date_now = date('Y-m-d');
		
		$products = ProductInventory::with('product.category')
        ->get();

    	$product_categories = ProductCategory::all();

        return view('admin.inventories.index', ['products' => $products,'product_categories' => $product_categories]);
    }
	

	public function inventoriesBranch($id) {
		$date_now = date('Y-m-d');
	
		$branch = Branch::find($id);
	
		$products = Product::join('product_inventories', 'product_inventories.product_id', '=', 'products.id')
			->join('product_categories', 'products.category', '=', 'product_categories.id')
			->where('products.status', 1)
			->where('product_inventories.branch_id', $id)
			->select('product_inventories.branch_id', 'product_inventories.quantity AS qty', 'products.*', 'product_categories.name as category_name')
			->get();
	
		$product_categories = ProductCategory::all();
		$branches = Branch::where('status', 1)->get();
	
		return view('admin.inventories.all-inventories', compact('products', 'product_categories', 'branches', 'branch'));
	}
	

    //Begininng Inventories from products table
    public function begininng_inventories(){
		
		$date_now = date('Y-m-d');
		
		$products = DB::table('products')
			//->leftJoin('products', 'product_inventories.product_id','=','products.id')
			->leftJoin('product_categories', 'products.category', '=', 'product_categories.id')
			->select('products.*', 'product_categories.name as category_name')
			->where('products.status',1)
			->get();
	   $product_categories = DB::table('product_categories')->get();	

        return view('admin.inventories.beginning-inventories', ['products' => $products,'product_categories' => $product_categories]);
    }
	
	// Get Inventory Datas
    public function count(Request $request){
		$id = $request['id'];
        $products = DB::table('products')
			->leftJoin('packages', 'products.category', '=', 'packages.id')
			->Join('product_inventories', 'products.id', '=', 'product_inventories.product_id')
			->select('products.*', 'packages.type','product_inventories.quantity as quantity')
			->where('products.id',$id)
            ->first();
        return response()->json($products);
    }
	
	
	//Transaction
	public function movements(Request $request){
		$id = $request['id'];
		$quantity = $request['quantity'];
		
        $product_inventory=ProductInventory::where('product_id',$id)->first();
		if($product_inventory){
			DB::beginTransaction();
            try {
				$entry_type = $request['entry_type'];
				$product_transaction = new ProductTransaction();
				$product_transaction->product_id = $id;
				//$product_transaction->user_id = ;
				$product_transaction->transaction_id = Str::uuid();
				//$product_transaction->transfer_id = ;
				$product_transaction->entry_type = $entry_type;
				$product_transaction->quantity = $request['quantity'];
				$product_transaction->admin_id = Auth::id();
				$product_transaction->save();
				if($entry_type == 'outgoing'){
					$product_inventory->quantity = $product_inventory->quantity - $quantity;
				} else if($entry_type == 'incoming'){
					$product_inventory->quantity = $product_inventory->quantity + $quantity;
				}  
				$product_inventory->save();
				DB::commit();
				return response()->json();
				
			}catch(\Throwable $e){
				DB::rollback();
				return response()->json([
					'message' => $e->getMessage(),
				],500);
			}
			
		} else {
			return response()->json([
				'message' => 'Product ID not Found!',
			],500);
		}
        
    }
	
	//Add Stokcs View
	 public function addStocks(){
        $productsData = DB::table('products')->where('category','!=',1)->get();
        $packagesData = DB::table('products')->where('category',1)->get();
		$products = DB::table('product_inventories')
			 ->leftJoin('products', 'product_inventories.product_id','=','products.id')
			 ->leftJoin('product_categories', 'products.category', '=', 'product_categories.id')
			 ->select('product_inventories.quantity','products.*', 'product_categories.name as category_name')
			 //->where('products.category','!=', 1)
			 ->get();
		$product_categories = DB::table('product_categories')->get();
		$branches = DB::table('branches')->get();
 
		 return view('admin.inventories.add-stocks', compact('products','product_categories','branches','productsData','packagesData'));
    }
    
    public function addStocksMovement(Request $request){
		DB::beginTransaction();
		try {
			$data =$request['data'];
			//$fromBranch =$request['branch_from'];
			$toBranch =$request['branch_to'];
			$data = $request['data'];
			$insert_data = null;
			foreach ($data as $value) {
				$data = array(
					//'transaction_info_id' => $product_transaction_info->id,
					'product_id' => $value['id'],
					'quantity' => $value['qty'],
					//'branch_from' => $fromBranch,
					'branch_to' => $toBranch,
					'transaction_id' => Str::uuid(),
					'admin_id' => Auth::id(),
					'entry_type' => 'stocks_incoming'
				);

						/*$product_inventory=ProductInventory::where('product_id',$value['id'])->where('branch_id',$fromBranch)->first();
						if($product_inventory){*/
							//$product_inventory->quantity = $product_inventory->quantity - $value['qty'];
							//$product_inventory->save();
							
							$product_inventory_add = ProductInventory::where('product_id',$value['id'])->where('branch_id',$toBranch)->first();
							if(empty($product_inventory_add)){
								$product_inventory_add = new ProductInventory();
								$product_inventory_add->branch_id = $toBranch;
								$product_inventory_add->product_id = $value['id'];
							}
							$product_inventory_add->quantity = $product_inventory_add->quantity + $value['qty'];
							$product_inventory_add->save();
							//return response()->json();
						/*} else {
							return response()->json([
								'message' => 'Product ID not Found!',
							],400);
						}*/
				$insert_data[] = $data; 
			}

			if($insert_data){
				ProductTransaction::insert($insert_data);
				// Insert User Log
				$user_log = new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 21; // Description ID
				$user_log->save();
				DB::commit();
				
				return response()->json([
					'success' => true
				],200);
			} else {
				return response()->json([
				  'message' => 'Quantity Empty!',
			   ],400);
			}

		
			} catch(\Throwable $e) {
				DB::rollback();
				
				// Insert User Log Error
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 21; // Description ID
				$user_log->status = "Error"; 
				$user_log->error = $e->getMessage();
				$user_log->save();
				
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}
	 }
	
	public function storeStocks(Request $request){
		DB::beginTransaction();
		try {
			$branch_from_id = $request['branch_from'];
			$branch_to_id = $request['branch_to'];
			$product_transaction_info =  new ProductTransactionInfo();
			if($request->ajax()){
				$product = $request->product_id;
				$qty = $request->product_qty;
				$price = $request->product_price;
				
				if(!empty($qty)){
					for($count = 0; $count < count($product); $count++){
						
						$data = array(
							//'transaction_info_id' => $product_transaction_info->id,
							'product_id' => $product[$count],
							'quantity' => $qty[$count],
							'branch_from' => $branch_from_id,
							'branch_to' => $branch_to_id,
							'transaction_id' => Str::uuid(),
							'admin_id' => Auth::id(),
							'entry_type' => 'stocks_incoming'
						);

						
						$product_inventory=ProductInventory::where('product_id',$product[$count])->where('branch_id',$branch_from_id)->first();
						if($product_inventory){
							$product_inventory->quantity = $product_inventory->quantity - $qty[$count];
							$product_inventory->save();
							
							$product_inventory_add=ProductInventory::where('product_id',$product[$count])->where('branch_id',$branch_to_id)->first();
							if(empty($product_inventory_add)){
								$product_inventory_add = new ProductInventory();
								$product_inventory_add->branch_id = $branch_to_id;
								$product_inventory_add->product_id = $product[$count];
							}
							$product_inventory_add->quantity = $product_inventory_add->quantity + $qty[$count];
							$product_inventory_add->save();
							//return response()->json();
						} else {
							return response()->json([
								'message' => 'Product ID not Found!',
							],400);
						}

						$insert_data[] = $data; 
						
					}
					ProductTransaction::insert($insert_data);
					
					// Insert User Log
					$user_log = new UserLog();
					$user_log->user_id = Auth::id();
					$user_log->description = 21; // Description ID
					$user_log->save();
					DB::commit();
					 
					return response()->json([
						'success' => true
					],200);
				} else {
					return response()->json([
						'message' => 'Quantity Empty!',
					],400);
				}
			}
		} catch(\Throwable $e) {
			DB::rollback();
			
			// Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 21; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
			$user_log->save();
			
			return response()->json([
				'message' => $e->getMessage(),
			],400);
		}
	}
	
    //Transfer Stocks VIEW
	public function transferStocks(){
		$productsData = DB::table('products')->where('products.status', 1)->where('category','!=',1)->get();
        $packagesData = DB::table('products')->where('category',1)->get();
		$products = DB::table('product_inventories')
            ->leftJoin('products', 'product_inventories.product_id','=','products.id')
            ->leftJoin('product_categories', 'products.category', '=', 'product_categories.id')
            ->select('product_inventories.quantity','products.*', 'product_categories.name as category_name')
            ->where('products.status', 1)
            //->where('products.category','!=', 1)
            ->get();
		$product_categories = DB::table('product_categories')->get();
		$branches = DB::table('branches')->where('status',1)->get();
 
		 return view('admin.inventories.transfer-stocks', compact('products','product_categories','branches','productsData','packagesData'));
	 }

	 public function transferStocksMovement(Request $request) {
		DB::beginTransaction();
	
		try {
			$fromBranch = $request['branch_from'];
			$toBranch = $request['branch_to'];
			$data = $request['data'];
			
			foreach ($data as $value) {
				$productInventoryFrom = ProductInventory::where('product_id', $value['id'])->where('branch_id', $fromBranch)->first();
				
				if (!$productInventoryFrom) {
					DB::rollback();
					return response()->json([
						'message' => 'Product ID not Found!',
					], 400);
				}
				
				$productInventoryFrom->quantity -= $value['qty'];
				$productInventoryFrom->save();
				
				$productInventoryTo = ProductInventory::firstOrNew(['product_id' => $value['id'], 'branch_id' => $toBranch]);
				$productInventoryTo->quantity += $value['qty'];
				$productInventoryTo->save();
				
				$data = [
					'product_id' => $value['id'],
					'quantity' => $value['qty'],
					'branch_from' => $fromBranch,
					'branch_to' => $toBranch,
					'transaction_id' => Str::uuid(),
					'admin_id' => Auth::id(),
					'entry_type' => 'stocks_outgoing'
				];
				
				ProductTransaction::create($data);
			}
	
			// Insert User Log
			$userLog = new UserLog();
			$userLog->user_id = Auth::id();
			$userLog->description = 22; // Description ID
			$userLog->save();
	
			DB::commit();
			
			return response()->json([
				'success' => true
			], 200);
	
		} catch (\Throwable $e) {
			DB::rollback();
			
			// Insert User Log Error
			$userLog = new UserLog();
			$userLog->user_id = Auth::id();
			$userLog->description = 22; // Description ID
			$userLog->status = "Error"; 
			$userLog->error = $e->getMessage();
			$userLog->save();
			
			return response()->json([
				'message' => $e->getMessage(),
			], 400);
		}
	}
	

    public function edit(Request $request){
        $id = $request['id'];
        
        $products = DB::table('products')
			//->leftJoin('packages', 'products.category', '=', 'packages.id')
			->Join('product_inventories', 'products.id', '=', 'product_inventories.product_id')
			->select('product_inventories.product_id AS product_id','products.name','product_inventories.quantity as quantity','product_inventories.branch_id')
			//->where('products.category','!=',1)
			->where('products.status',1)
			->where('product_inventories.status',1)
			->where('product_inventories.quantity','>=',1)
			->where('product_inventories.branch_id',$id)
            ->get();
        return response()->json([
            'products_data' => $products
        ]);
	}
	

	public function getProductData(Request $request){
		
		$productId = $request['productId'];
		$branchId = $request['branchId'];
		
        $products = DB::table('product_inventories')
			->where('product_inventories.branch_id',$branchId)
			->where('product_inventories.product_id',$productId)
            ->first();
        return response()->json([
            'products_data' => $products
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductInventory $productInventory)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductInventory $productInventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductInventory $productInventory)
    {
        //
    }
}
