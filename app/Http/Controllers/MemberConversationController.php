<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use App\MessageAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MemberConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show member inbox with all conversations
     * GET /user/messages
     */
    public function inbox()
    {
        $memberId = Auth::id();

        // Verify user is a member
        if (Auth::user()->userType !== 'user') {
            abort(403, 'Unauthorized');
        }

        $conversations = Conversation::forMember($memberId)
            ->with(['admin', 'latestMessage.sender'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(15);

        // Calculate unread counts
        foreach ($conversations as $conversation) {
            $conversation->unread_count = $conversation->unreadCount($memberId);
        }

        return view('user.messages.inbox', compact('conversations'));
    }

    /**
     * Show specific conversation for member
     * GET /user/messages/{conversation}
     */
    public function show(Conversation $conversation)
    {
        $memberId = Auth::id();

        // Verify user is the member in this conversation
        if ($conversation->member_id !== $memberId) {
            abort(403, 'Unauthorized');
        }

        // Load messages with sender info
        $messages = $conversation->messages()
            ->with(['sender', 'attachments'])
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        // Mark unread messages to this member as read
        $conversation->messages()
            ->where('recipient_id', $memberId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('user.messages.show', compact('conversation', 'messages'));
    }

    /**
     * Reply to a conversation (member can only reply, not initiate)
     * POST /user/messages/{conversation}/reply
     */
    public function reply(Request $request, Conversation $conversation)
    {
        $memberId = Auth::id();

        // Verify user is the member in this conversation
        if ($conversation->member_id !== $memberId) {
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
            // Create reply message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $memberId,
                'recipient_id' => $conversation->admin_id,
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
                'message' => 'Reply sent successfully',
                'data' => $message->load(['sender', 'attachments']),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show form to compose new message to admin
     * GET /user/messages/compose
     */
    public function compose()
    {
        // Get all active staff members
        $admins = \App\User::where('status', 1)
            ->where('userType', 'staff')
            ->orderBy('username')
            ->get(['id', 'username', 'email']);

        return view('user.messages.compose', compact('admins'));
    }

    /**
     * Store new message/conversation from member to admin
     * POST /user/messages
     */
    public function store(Request $request)
    {
        $memberId = Auth::id();

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $adminId = $request->input('admin_id');

            // Check if conversation already exists with this admin
            $conversation = Conversation::where('member_id', $memberId)
                ->where('admin_id', $adminId)
                ->first();

            if (!$conversation) {
                // Create new conversation
                $conversation = Conversation::create([
                    'member_id' => $memberId,
                    'admin_id' => $adminId,
                    'subject' => $request->input('subject'),
                    'last_message_at' => now(),
                    'status' => 'active',
                ]);
            }

            // Create message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $memberId,
                'recipient_id' => $adminId,
                'content' => $request->input('content'),
            ]);

            // Handle attachments if needed
            if ($request->hasFile('attachments')) {
                $this->storeAttachments($request->file('attachments'), $message);
            }

            // Update conversation's last message time
            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return response()->json([
                'message' => 'Message sent successfully',
                'conversation_id' => $conversation->id,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download attachment
     * GET /user/messages/attachment/{attachment}/download
     */
    public function downloadAttachment(MessageAttachment $attachment)
    {
        $memberId = Auth::id();

        // Verify user has access to this message
        $message = $attachment->message;
        $conversation = $message->conversation;

        if ($conversation->member_id !== $memberId && $conversation->admin_id !== $memberId) {
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
        $directory = public_path('attachments/messages/' . $message->conversation_id);

        // Create directory if it doesn't exist
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        foreach ($files as $file) {
            // Validate file
            if ($file->getSize() > 10485760) { // 10MB limit
                continue; // Skip if too large
            }

            $filename = $file->getClientOriginalName();
            $storedName = time() . '_' . $filename;
            $file->move($directory, $storedName);

            // Create attachment record
            MessageAttachment::create([
                'message_id' => $message->id,
                'filename' => $filename,
                'stored_path' => 'attachments/messages/' . $message->conversation_id . '/' . $storedName,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }
}
