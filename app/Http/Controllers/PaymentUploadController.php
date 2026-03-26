<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\PaymentUpload;

class PaymentUploadController extends Controller
{
    /**
     * Display the payment upload page
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get user's payment uploads
        $payments = PaymentUpload::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.payments.index', compact('payments'));
    }

    /**
     * Store the uploaded payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240', // Max 10MB
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $user = Auth::user();
            $file = $request->file('attachment');
            
            // Create directory if it doesn't exist
            $uploadDir = public_path('payment_uploads/' . $user->id);
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Store file in public folder
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $path = 'payment_uploads/' . $user->id . '/' . $filename;
            
            // Create payment upload record
            PaymentUpload::create([
                'user_id' => $user->id,
                'user_name' => $user->username ?? $user->first_name . ' ' . $user->last_name,
                'file_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'status' => 'pending', // pending, approved, rejected
                'notes' => $request->input('notes'),
            ]);

            return redirect()->route('user.payments')
                ->with('success', 'Payment uploaded successfully. Awaiting admin approval.');
        } catch (\Exception $e) {
            return redirect()->route('user.payments')
                ->with('error', 'Failed to upload payment: ' . $e->getMessage());
        }
    }

    /**
     * Download the payment attachment
     */
    public function download($id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        // Check if user owns this payment or is admin
        if (Auth::id() !== $payment->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $filePath = public_path($payment->file_path);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        return response()->download($filePath, $payment->original_filename);
    }

    /**
     * Delete the payment upload (only if pending)
     */
    public function destroy($id)
    {
        $payment = PaymentUpload::findOrFail($id);
        
        // Check ownership
        if (Auth::id() !== $payment->user_id) {
            abort(403, 'Unauthorized');
        }

        // Only allow deletion if pending
        if ($payment->status !== 'pending') {
            return redirect()->route('user.payments')
                ->with('error', 'Cannot delete ' . $payment->status . ' payments.');
        }

        try {
            // Delete file from public folder
            $filePath = public_path($payment->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete record
            $payment->delete();

            return redirect()->route('user.payments')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.payments')
                ->with('error', 'Failed to delete payment: ' . $e->getMessage());
        }
    }
}
