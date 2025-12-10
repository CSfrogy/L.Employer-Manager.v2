<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;

class MailboxController extends Controller
{
    public function index()
    {
        $messages = Message::with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $unreadCount = Message::unread()->count();

        return view('admin.mailbox.index', compact('messages', 'unreadCount'));
    }

    public function show(Message $message)
    {
        if (!$message->isRead()) {
            $message->markAsRead();
        }

        return view('admin.mailbox.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.mailbox.index')
            ->with('success', 'Message deleted successfully');
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'reply_content' => 'required|string|max:2000'
        ]);

        try {
            MessageReply::create([
                'message_id' => $message->id,
                'sender_id' => auth()->id(), 
                'sender_type' => 'admin',
                'reply_content' => $request->reply_content
            ]);

            return redirect()->route('admin.mailbox.show', $message)
                ->with('success', 'Reply sent successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.mailbox.show', $message)
                ->with('error', 'Failed to send reply. Please try again.');
        }
    }

    public function markAsRead(Message $message)
    {
        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAsUnread(Message $message)
    {
        $message->update(['read_at' => null]);

        return response()->json(['success' => true]);
    }
}
