<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use App\MessageAttachment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StaffConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all conversations for the admin
     * GET /staff/messages
     */
    public function index()
    {
        $adminId = Auth::id();

        // Verify user is staff
        if (Auth::user()->userType !== 'staff') {
            abort(403, 'Unauthorized');
        }

        $conversations = Conversation::forAdmin($adminId)
            ->with(['member', 'latestMessage.sender'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(15);

        return view('staff.conversations.index', compact('conversations'));
    }

    /**
     * Show form to start new conversation
     * GET /staff/conversations/create
     */
    public function create()
    {
        if (Auth::user()->userType !== 'staff') {
            abort(403, 'Unauthorized');
        }

        // Get list of members (users with userType = 'user')
        $members = User::where('userType', 'user')
            ->where('status', 1)
            ->orderBy('username')
            ->get();

        return view('staff.conversations.create', compact('members'));
    }

    /**
     * Start a new conversation
     * POST /staff/conversations
     */
    public function store(Request $request)
    {
        $adminId = Auth::id();

        // Verify user is staff
        if (Auth::user()->userType !== 'staff') {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $memberId = $request->input('member_id');

        // Verify the selected user is actually a member
        $member = User::find($memberId);
        if (!$member || $member->userType !== 'user') {
            return response()->json(['message' => 'Invalid member selected'], 422);
        }

        // Prevent admin from messaging themselves
        if ($adminId === $memberId) {
            return response()->json(['message' => 'Cannot message yourself'], 422);
        }

        DB::beginTransaction();
        try {
            // Create or get existing conversation
            $conversation = Conversation::firstOrCreate(
                ['admin_id' => $adminId, 'member_id' => $memberId],
                ['subject' => $request->input('subject')]
            );

            // Save the first message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $adminId,
                'recipient_id' => $memberId,
                'content' => $request->input('message'),
            ]);

            // Handle attachments if present
            if ($request->hasFile('attachments')) {
                $this->storeAttachments($request->file('attachments'), $message);
            }

            // Update conversation's last message time
            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return response()->json([
                'message' => 'Conversation started successfully',
                'conversation_id' => $conversation->id,
                'redirect' => route('staff.messages.show', $conversation->id),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show conversation details and messages
     * GET /staff/conversations/{conversation}
     */
    public function show(Conversation $conversation)
    {
        $adminId = Auth::id();

        // Verify user is the admin in this conversation
        if ($conversation->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        $messages = $conversation->messages()
            ->with(['sender', 'attachments'])
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return view('staff.conversations.show', compact('conversation', 'messages'));
    }

    /**
     * Send reply message
     * POST /staff/conversations/{conversation}/reply
     */
    public function reply(Request $request, Conversation $conversation)
    {
        $adminId = Auth::id();

        // Verify user is the admin in this conversation
        if ($conversation->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // Create message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $adminId,
                'recipient_id' => $conversation->member_id,
                'content' => $request->input('content'),
            ]);

            // Handle attachments
            if ($request->hasFile('attachments')) {
                $this->storeAttachments($request->file('attachments'), $message);
            }

            // Update conversation's last message time
            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return response()->json([
                'message' => 'Message sent successfully',
                'data' => $message->load(['sender', 'attachments']),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download attachment
     * GET /staff/messages/attachment/{attachment}
     */
    public function downloadAttachment(MessageAttachment $attachment)
    {
        $adminId = Auth::id();

        // Verify user has access to this message
        $message = $attachment->message;
        $conversation = $message->conversation;

        if ($conversation->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        $filePath = public_path($attachment->stored_path);

        if (!File::exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->filename);
    }

    /**
     * Store attachments for a message
     */
    private function storeAttachments($files, Message $message)
    {
        $directory = 'attachments/messages/' . $message->conversation_id;
        $fullPath = public_path($directory);

        // Create directory if it doesn't exist
        if (!File::isDirectory($fullPath)) {
            if (!File::makeDirectory($fullPath, 0755, true, true)) {
                throw new \Exception('Failed to create attachments directory');
            }
        }

        foreach ($files as $file) {
            // Validate file
            if (!$file->isValid()) {
                throw new \Exception('File upload error: ' . $file->getErrorMessage());
            }

            if ($file->getSize() > 10485760) { // 10MB limit
                throw new \Exception('File "' . $file->getClientOriginalName() . '" exceeds 10MB limit');
            }

            if ($file->getSize() === 0) {
                throw new \Exception('File "' . $file->getClientOriginalName() . '" is empty');
            }

            try {
                $filename = $file->getClientOriginalName();
                $storedName = time() . '_' . uniqid() . '_' . $filename;

                // Use storeAs for better file handling
                $path = $file->storeAs(
                    $directory,
                    $storedName,
                    'public'
                );

                if (!$path) {
                    throw new \Exception('Failed to store file');
                }

                // Create attachment record
                MessageAttachment::create([
                    'message_id' => $message->id,
                    'filename' => $filename,
                    'stored_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            } catch (\Exception $e) {
                throw new \Exception('Failed to save file: ' . $e->getMessage());
            }
        }
    }

    /**
     * Delete a conversation
     * DELETE /staff/messages/{conversation}
     */
    public function destroy(Conversation $conversation)
    {
        $adminId = Auth::id();

        // Verify user is staff
        if (Auth::user()->userType !== 'staff') {
            abort(403, 'Unauthorized');
        }

        // Verify user is the admin in this conversation
        if ($conversation->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        DB::beginTransaction();
        try {
            // Delete attachments
            foreach ($conversation->messages as $message) {
                MessageAttachment::where('message_id', $message->id)->delete();
            }

            // Delete messages
            Message::where('conversation_id', $conversation->id)->delete();

            // Delete conversation
            $conversation->delete();

            DB::commit();

            return redirect()->route('staff.messages.index')->with('success', 'Conversation deleted successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error deleting conversation: ' . $e->getMessage());
        }
    }
}
