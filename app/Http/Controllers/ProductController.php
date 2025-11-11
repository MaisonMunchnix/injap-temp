<?php

namespace App\Http\Controllers;
use App\Sale;
use Session;
use App\Product;
use App\User;
use App\UserLog;
use App\ProductInventory;
use App\ProductDiscount;

use App\ProductTransaction;
use App\ProductCategory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_now = date('Y-m-d');

        $products = Product::leftJoin('product_categories', 'products.category', '=', 'product_categories.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('products.status',1)
            ->where('products.category','!=',1)
            ->get();

        $product_categories = ProductCategory::all();

        return view('admin.products.index', compact('products', 'product_categories'));
    }

	
	public function index_categories()
    {
        $productCategories = ProductCategory::all();
        return view('TellerSystem.product-categories', compact('productCategories'));
    }


    public function ewallet_purchases()
    {
        $orders = Sale::whereHas('payment', function ($query) {
            $query->where('status', 1)
                ->where('is_paid', 0)
                ->where('driver', 'EWalletPaymentGateway');
        })->where('products_released', 0)->get();

        return view('admin.ewallet.process_order', compact('orders'));
    }


    public function record_sale(Sale $sale)
    {
        return $sale;
    }

    public function approve_purchase(Request $request, Sale $sale)
    {
        if (!Auth::check() || Auth::user()->userType !== 'staff') {
            return redirect('/login');
        }

        $actionMsg = "";

        if ($request->has('action')) {
            if ($request->action === 'approve') {
                $sale->payment()->update(['is_paid' => 1]);
                $actionMsg = "E-wallet purchase successfully approved.";
            } elseif ($request->action === 'decline') {
                $sale->payment()->update([
                    'status' => 2,
                    'error' => "The user's request of e-wallet purchase was declined by the admin",
                ]);
                $sale->update(['products_released' => 3]);
                $actionMsg = "E-wallet purchase successfully declined.";
            }
        }

        return back()->with('alert', $actionMsg);
    }

	
	
	

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function create()
     {
         $product_categories = ProductCategory::all();
     
         return view('admin.products.add-product', compact('product_categories'));
     }
     
	
     public function store(StoreProductRequest $request)
     {
         return DB::transaction(function () use ($request) {
             $validatedData = $request->validated();
             $code = Str::slug($validatedData['name']);
             
             if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image_dir = 'assets/img/product/';
            
                if (!is_dir(public_path($image_dir))) {
                    mkdir(public_path($image_dir), 0777, true);
                }
            
                $image->move(public_path($image_dir), $imageName);
                $image_path = $image_dir . $imageName;
             } else {
                 $image_path = null;
             }
             
             $product = Product::create([
                 'name' => $validatedData['name'],
                 'description' => $validatedData['description'],
                 'critical_level' => $validatedData['critical_level'],
                 'price' => $validatedData['price'],
                 'cost_price' => $validatedData['cost_price'],
                 'reward_points' => $this->percentToDecimal($validatedData['reward_points']),
                 'code' => $code,
                 'category' => 2,
                 'image' => $image_path,
             ]);
     
             $product->inventory()->updateOrCreate(['branch_id' => 1], [
                 'quantity' => $validatedData['quantity'],
             ]);
     
             $product->transactions()->create([
                 'branch_to' => 1,
                 'transaction_id' => Str::uuid(),
                 'admin_id' => Auth::id(),
                 'entry_type' => 'incoming',
                 'quantity' => $validatedData['quantity'],
             ]);
     
             UserLog::create([
                 'user_id' => Auth::id(),
                 'description' => 17,
             ]);
     
             return response()->json();
         });
     }

    private function percentToDecimal($percent): float
    {
        $percent = str_replace('%', '', $percent);
        return $percent / 100.00;
    }

	
    public function store_category(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $name = $request->input('name');
            $productCategory = new ProductCategory(['name' => $name]);
            $productCategory->save();
    
            DB::commit();
            $request->session()->flash('successMsg', $name . ' Added successfully!');
            return redirect()->route('product-categories.index');
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
	
	
	// Get Products Datas
    public function productEdit($id)
    {
        $user = Auth::user();
        
        $query = Product::leftJoin('packages', 'products.category', '=', 'packages.id')
            ->leftJoin('product_inventories', 'products.id', '=', 'product_inventories.product_id')
            ->select('products.*', 'packages.type', 'packages.amount', 'product_inventories.quantity', 'product_inventories.branch_id');
        
        if ($user->userType == 'teller') {
            $query->where('product_inventories.branch_id', $user->branch_id)
                ->where('product_inventories.product_id', $id);
        } else {
            $query->where('products.id', $id);
        }
        
        $product = $query->first();

        return response()->json($product);
    }

    
    
    public function product_transaction(Request $request)
    {
        $productId = $request->input('id');

        $productPrice = Product::where('id', $productId)
            ->select('price')
            ->first();

        return response()->json($productPrice);
    }

    
    public function package_transaction(Request $request){
        $user = Auth::user();
        $id = $request->input('id'); // Package ID
        $memberId = $request->input('username');
        $buyer = User::find($memberId);

        $memberType = $buyer->member_type ?? null;

        $package = Product::where('id', $id)
            ->where('category', 1)
            ->first();

        return response()->json([
            'price' => $package->price,
            'stocks' => 1000,
        ]);

    }
    
    // Get Products Datas on New Transaction
    public function admin_product_transaction(Request $request){
		$id = $request->input('id');

        $product = Product::leftJoin('packages', 'products.category', '=', 'packages.id')
            ->leftJoin('product_inventories', 'products.id', '=', 'product_inventories.product_id')
            ->leftJoin('product_discounts', 'products.id', '=', 'product_discounts.product_id')
            ->select('products.*', 'product_discounts.*', 'packages.type', 'packages.amount', 'product_inventories.quantity', 'product_inventories.branch_id')
            ->where('products.id', $id)
            ->first();

        return response()->json($product);

    }
    
    public function admin_package_transaction(Request $request){
        $id = $request['id']; //Package ID

        $product = Product::find($id);
        
        $package = DB::table('packages')
            ->select('amount')
			->where('id',$product->package_id)
            ->first();
        
        $stocks = DB::table('product_inventories')
            ->select('product_inventories.quantity AS quantity')
            ->where('product_inventories.product_id',$id)
            ->first();
        
        return response()->json([
            'price' => $package->amount,
            'stocks' => $stocks->quantity,
        ]);

    }
	
	public function productView(Request $request)
    {
        $products = DB::table('products')->find($request['id']);
        return response()->json($products);
    }
    
    public function product_movementView(Request $request){
        $id = $request['id'];
        $type = $request['type'];
        $from_date = $request['from_date'];
        $to_date = $request['to_date'];
        //$out = $request['out'];
        $branch_id = $request['branch_id'];
        
        
        if($from_date){
            if($type == 'out'){
                $product_movements = DB::table('product_transactions')
                ->select('user_id','branch_from','branch_to','entry_type','quantity','created_at')
                ->where('entry_type','!=','package_outgoing')
                ->where('product_id',$id)
                ->where('branch_from',$branch_id)
                ->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
                ->get();
            } else if($type == 'in'){
                $product_movements = DB::table('product_transactions')
                ->select('user_id','branch_from','branch_to','entry_type','quantity','created_at')
                ->where('entry_type','!=','package_outgoing')
                ->where('product_id',$id)
                ->where('branch_to',$branch_id)
                ->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
                ->get();
            }
        } else {
            if($type == 'out'){
                $product_movements = DB::table('product_transactions')
                    ->select('user_id','branch_from','branch_to','entry_type','quantity','created_at')
                    ->where('entry_type','!=','package_outgoing')
                    ->where('product_id',$id)
                    ->where('branch_from',$branch_id)
                    ->get();
            } else if($type == 'in'){
                $product_movements = DB::table('product_transactions')
                    ->select('user_id','branch_from','branch_to','entry_type','quantity','created_at')
                    ->where('entry_type','!=','package_outgoing')
                    ->where('product_id',$id)
                    ->where('branch_to',$branch_id)
                    ->get();
            }
        }
   
        return response()->json([
            'data' => $product_movements
        ]);
    }
    
    
	
	//Update Product
    public function productUpdate(Request $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($request->input('id'));
            $entry_type = $request->input('entry_type');

            if ($entry_type) {
                $product_transaction = new ProductTransaction();
                $product_transaction->product_id = $request->input('id');
                $product_transaction->transaction_id = Str::uuid();
                $product_transaction->entry_type = $entry_type;
                $product_transaction->quantity = $request->input('quantity');
                $product_transaction->admin_id = Auth::id();
                $product_transaction->save();

                if ($entry_type == 'outgoing') {
                    $product->quantity -= $request->input('quantity');
                } elseif ($entry_type == 'incoming') {
                    $product->quantity += $request->input('quantity');
                }
            } else {
                $product->fill($request->only(['name', 'critical_level', 'description', 'cost_price','price', 'reward_points','unilevel_price']) + ['category' => $request->input('category', 2)]);

                if ($request->hasFile('image')) {
                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
                    ]);

                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $imagePath = 'assets/img/product/';

                    if (!is_dir(public_path($imagePath))) {
                        mkdir(public_path($imagePath), 0777, true);
                    }

                    $image->move(public_path($imagePath), $imageName);
                    $product->image = $imagePath . $imageName;
                }
            }

            $product->save();

            // Insert User Log
            UserLog::create([
                'user_id' => Auth::id(),
                'description' => 19, // Description ID
            ]);

            DB::commit();
            return response()->json();
        } catch (\Throwable $e) {
            DB::rollback();

            // Insert User Log Error
            UserLog::create([
                'user_id' => Auth::id(),
                'description' => 19, // Description ID
                'status' => 'Error',
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }



	
    
	
	// Get Category Datas
    public function categoryEdit(Request $request){
		$id = $request['id'];
        $product_categories = DB::table('product_categories')->first();
        return response()->json($product_categories);
    }
	
	//Update Category
	public function categorytUpdate(Request $request){
		DB::beginTransaction();
		try {
			$product_category=ProductCategory::find($request['id']);
			$product_category->name = $request['name'];
			$product_category->save();
			DB::commit();
			return response()->json();
		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }
	
	

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                $product->update(['status' => 2]);
            });

            return response()->json();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
