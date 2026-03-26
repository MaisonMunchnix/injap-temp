<?php

namespace App\Http\Controllers;

use App\NewProduct;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display the product management page
     */
    public function index()
    {
        return view('admin.new_products.index');
    }

    /**
     * Show create product form
     */
    public function create()
    {
        return redirect()->route('admin.products');
    }

    /**
     * Get products list as JSON
     */
    public function getList()
    {
        try {
            $products = NewProduct::all();
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
     * Get categories list as JSON
     */
    public function getCategoriesList()
    {
        // Since there's no category table, returning empty array
        // You can modify this later when you add categories
        return response()->json([
            'categories' => []
        ]);
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            // Handle file upload to public/products/
            $picturePath = null;
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $validated['picture'] = 'products/' . $filename;
            }

            NewProduct::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get a single product for viewing
     */
    public function view($id)
    {
        try {
            $product = NewProduct::findOrFail($id);
            return response()->json([
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Get a product for editing
     */
    public function edit($id)
    {
        try {
            $product = NewProduct::findOrFail($id);
            return response()->json([
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Update a product
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:new_products,id',
                'product_name' => 'required|string|max:255',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $product = NewProduct::findOrFail($validated['product_id']);

            // Handle file upload to public/products/
            if ($request->hasFile('picture')) {
                // Delete old picture if exists
                if ($product->picture && file_exists(public_path($product->picture))) {
                    unlink(public_path($product->picture));
                }
                $file = $request->file('picture');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $validated['picture'] = 'products/' . $filename;
            }

            // Remove product_id from validated array before updating
            unset($validated['product_id']);
            
            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete a product
     */
    public function delete($id)
    {
        try {
            $product = NewProduct::findOrFail($id);

            // Delete picture if exists
            if ($product->picture && file_exists(public_path($product->picture))) {
                unlink(public_path($product->picture));
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product'
            ], 500);
        }
    }

    /**
     * View pending product submissions
     */
    public function viewPendingSubmissions()
    {
        try {
            $submissions = NewProduct::with('submitter')
                ->where('status', 'pending')
                ->orderBy('submitted_at', 'desc')
                ->paginate(15);

            return view('admin.new_products.pending-submissions', compact('submissions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.products')
                ->with('error', 'Error loading submissions');
        }
    }

    /**
     * Get pending submissions as JSON (for DataTable)
     */
    public function getPendingSubmissions()
    {
        try {
            $submissions = NewProduct::with('submitter')
                ->where('status', 'pending')
                ->orderBy('submitted_at', 'desc')
                ->get();

            return response()->json([
                'submissions' => $submissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching submissions'
            ], 500);
        }
    }

    /**
     * Approve a product submission
     */
    public function approveSubmission(Request $request)
    {
        try {
            $product = NewProduct::findOrFail($request->product_id);

            if ($product->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending products can be approved'
                ], 422);
            }

            // Update with admin-set price if provided
            $updateData = ['status' => 'approved'];
            if ($request->has('price') && $request->price !== '') {
                $updateData['price'] = $request->price;
            }

            $product->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Product approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error approving product'
            ], 500);
        }
    }

    /**
     * Reject a product submission
     */
    public function rejectSubmission(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:new_products,id',
                'rejection_reason' => 'nullable|string|max:500'
            ]);

            $product = NewProduct::findOrFail($validated['product_id']);

            if ($product->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending products can be rejected'
                ], 422);
            }

            // Delete the picture if exists
            if ($product->picture && file_exists(public_path($product->picture))) {
                unlink(public_path($product->picture));
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product rejected and deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting product'
            ], 500);
        }
    }
}

