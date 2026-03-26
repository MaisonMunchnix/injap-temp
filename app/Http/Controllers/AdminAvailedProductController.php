<?php

namespace App\Http\Controllers;

use App\AvailedProduct;
use App\NewProduct;
use Illuminate\Http\Request;

class AdminAvailedProductController extends Controller
{
    /**
     * View pending availed product orders
     */
    public function viewPendingOrders()
    {
        try {
            $orders = AvailedProduct::with(['user', 'product'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return view('admin.availed_products.pending-orders', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('admin-dashboard')
                ->with('error', 'Error loading orders');
        }
    }

    /**
     * View approved availed product orders
     */
    public function viewApprovedOrders()
    {
        try {
            $orders = AvailedProduct::with(['user', 'product'])
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return view('admin.availed_products.approved-orders', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('admin-dashboard')
                ->with('error', 'Error loading orders');
        }
    }

    /**
     * Get pending orders as JSON
     */
    public function getPendingOrders()
    {
        try {
            $orders = AvailedProduct::with(['user', 'product'])
                ->where('status', 'pending')
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

    /**
     * Approve an availed product order
     */
    public function approveOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:availed_products,id',
            ]);

            $order = AvailedProduct::findOrFail($validated['order_id']);

            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending orders can be approved'
                ], 422);
            }

            $order->update([
                'status' => 'approved'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error approving order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject an availed product order
     */
    public function rejectOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:availed_products,id',
                'rejection_reason' => 'nullable|string|max:500'
            ]);

            $order = AvailedProduct::findOrFail($validated['order_id']);

            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending orders can be rejected'
                ], 422);
            }

            // Delete attachment if exists
            if ($order->attachment && file_exists(public_path($order->attachment))) {
                unlink(public_path($order->attachment));
            }

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting order'
            ], 500);
        }
    }

    /**
     * Attach document to availed product order
     */
    public function attachDocument(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:availed_products,id',
                'attachment' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:10240'
            ]);

            $order = AvailedProduct::findOrFail($validated['order_id']);

            // Delete old attachment if exists
            if ($order->attachment && file_exists(public_path($order->attachment))) {
                unlink(public_path($order->attachment));
            }

            // Upload new attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = 'order_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('attachments/orders'), $filename);
                $order->update(['attachment' => 'attachments/orders/' . $filename]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Document attached successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error attaching document: ' . $e->getMessage()
            ], 422);
        }
    }
}
