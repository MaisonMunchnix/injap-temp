<?php

namespace App\Http\Controllers;

use App\NewProduct;
use App\AvailedProduct;
use Illuminate\Http\Request;

class MemberProductController extends Controller
{
    /**
     * Display the product browse page
     */
    public function browse()
    {
        return view('user.products.browse');
    }

    /**
     * Get all approved products as JSON for members
     */
    public function getProducts()
    {
        try {
            $products = NewProduct::where('status', 'approved')
                ->select('id', 'product_name', 'picture', 'price', 'description')
                ->get();
            
            return response()->json([
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching products'
            ], 500);
        }
    }

    /**
     * Get a single product details
     */
    public function getProduct($id)
    {
        try {
            $product = NewProduct::where('status', 'approved')->find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching product'
            ], 500);
        }
    }

    /**
     * Submit a new product for approval
     */
    public function submitProduct(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'country' => 'required|string|max:100',
                'address' => 'required|string|max:500',
                'contact_number' => 'required|string|max:20',
            ]);

            $validated['user_id'] = auth()->id();
            $validated['status'] = 'pending';
            $validated['submitted_at'] = now();

            // Handle file upload to public/products/
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $validated['picture'] = 'products/' . $filename;
            }

            NewProduct::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product submitted successfully! Admin will review it shortly.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Avail a product (member places order)
     */
    public function availProduct(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:new_products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = NewProduct::findOrFail($validated['product_id']);

            if ($product->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is not available'
                ], 422);
            }

            // Calculate total price
            $totalPrice = $product->price * $validated['quantity'];

            $availedProduct = AvailedProduct::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product order submitted successfully! Admin will review and process your request.',
                'order_id' => $availedProduct->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the my orders page
     */
    public function myOrders()
    {
        return view('user.products.my-orders');
    }

    /**
     * Get user's orders as JSON
     */
    public function getMyOrders()
    {
        try {
            $orders = AvailedProduct::where('user_id', auth()->id())
                ->with('product')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching orders'
            ], 500);
        }
    }
}
