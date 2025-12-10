<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $messages = Message::where('employee_id', Auth::id())
            ->with('employee')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $sentCount = Message::where('employee_id', Auth::id())->count();

        return view('employee.messages.index', compact('messages', 'sentCount'))
            ->with([
                'user' => $employee,
                'userRole' => 'employee'
            ]);
    }

    public function create()
    {
        $employee = Auth::guard('employee')->user();

        return view('employee.messages.create')
            ->with([
                'user' => $employee,
                'userRole' => 'employee'
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Message::create([
            'employee_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->route('employee.messages.index')
            ->with('success', 'Message sent successfully to administration.');
    }

    public function show(Message $message)
    {
        if ($message->employee_id !== Auth::id()) {
            return redirect()->route('employee.messages.index')
                ->with('error', 'You are not authorized to view this message.');
        }

        $message->load(['replies' => function($query) {
            $query->with(['admin', 'employee'])->orderBy('created_at', 'asc');
        }]);

        $employee = Auth::guard('employee')->user();

        return view('employee.messages.show', compact('message'))
            ->with([
                'user' => $employee,
                'userRole' => 'employee'
            ]);
    }

    public function destroy(Message $message)
    {
        if ($message->employee_id !== Auth::id()) {
            return redirect()->route('employee.messages.index')
                ->with('error', 'You are not authorized to delete this message.');
        }

        $message->delete();

        return redirect()->route('employee.messages.index')
            ->with('success', 'Message deleted successfully');
    }

    public function reply(Request $request, Message $message)
    {
        if ($message->employee_id !== Auth::id()) {
            return redirect()->route('employee.messages.index')
                ->with('error', 'You are not authorized to reply to this message.');
        }

        $request->validate([
            'reply_content' => 'required|string|max:2000'
        ]);

        try {
            MessageReply::create([
                'message_id' => $message->id,
                'sender_id' => Auth::id(),
                'sender_type' => 'employee',
                'reply_content' => $request->reply_content
            ]);

            return redirect()->route('employee.messages.show', $message)
                ->with('success', 'Reply sent successfully');
        } catch (\Exception $e) {
            return redirect()->route('employee.messages.show', $message)
                ->with('error', 'Failed to send reply. Please try again.');
        }
    }
}