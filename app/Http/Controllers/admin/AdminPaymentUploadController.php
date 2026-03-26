<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentUpload;
use Illuminate\Support\Facades\Storage;

class AdminPaymentUploadController extends Controller
{
    /**
     * Display all payment uploads
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search', '');
        
        $query = PaymentUpload::with('user')->orderBy('created_at', 'desc');
        
        // Filter by status
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Search by user name or filename
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('original_filename', 'like', "%{$search}%");
            });
        }
        
        $payments = $query->paginate(15);

        return view('admin.payments.index', compact('payments', 'status', 'search'));
    }

    /**
     * Get payment details via AJAX
     */
    public function show($id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        // Check if file exists
        $filePath = public_path($payment->file_path);
        $fileExists = file_exists($filePath);
        $isImage = false;
        
        if ($fileExists) {
            $extension = pathinfo($payment->original_filename, PATHINFO_EXTENSION);
            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
        }
        
        // Build correct file URL
        $fileUrl = null;
        if ($fileExists) {
            $fileUrl = '/' . $payment->file_path;
        }
        
        return response()->json([
            'id' => $payment->id,
            'user_name' => $payment->user->first_name ?? $payment->user_name,
            'original_filename' => $payment->original_filename,
            'file_path' => $fileUrl,
            'status' => $payment->status,
            'notes' => $payment->notes,
            'created_at' => $payment->created_at->format('M d, Y h:i A'),
            'isImage' => $isImage
        ]);
    }

    /**
     * Approve payment
     */
    public function approve(Request $request, $id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        try {
            $payment->update([
                'status' => 'approved',
                'notes' => $request->input('admin_notes') ?? $payment->notes,
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment approved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Failed to approve payment: ' . $e->getMessage());
        }
    }

    /**
     * Reject payment
     */
    public function reject(Request $request, $id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $payment->update([
                'status' => 'rejected',
                'notes' => $request->input('rejection_reason'),
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Failed to reject payment: ' . $e->getMessage());
        }
    }

    /**
     * Download payment attachment
     */
    public function download($id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        $filePath = public_path($payment->file_path);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        return response()->download($filePath, $payment->original_filename);
    }
}
