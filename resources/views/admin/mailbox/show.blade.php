@extends('admin.layouts.app')

@section('title', 'Message - ' . ($message->subject ?? 'Message Details'))

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div>
                        <h1>Message Details</h1>
                        <div class="page-title-subheading">
                            @if(isset($message) && $message->employee)
                                Reading message from {{ $message->employee->name }}
                            @else
                                Message Details
                            @endif
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('admin.mailbox.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Mailbox
                    </a>
                </div>
            </div>
        </div>

        @if(isset($message))
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="message-info">
                                    <h5 class="mb-1">{{ $message->subject }}</h5>
                                    <small class="text-muted">
                                        From: {{ $message->employee->name ?? 'Unknown' }}
                                        @if($message->employee && $message->employee->email)
                                            ({{ $message->employee->email }})
                                        @endif
                                    </small>
                                </div>

                                <div class="message-actions">
                                    @if(!$message->isRead())
                                        <button type="button" class="btn btn-success btn-sm" onclick="markAsRead({{ $message->id }})">
                                            <i class="fas fa-check"></i> Mark as Read
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-warning btn-sm" onclick="markAsUnread({{ $message->id }})">
                                            <i class="fas fa-envelope"></i> Mark as Unread
                                        </button>
                                    @endif
                                    <form method="POST" action="{{ route('admin.mailbox.destroy', $message) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                        </div>


                        <div class="card-body">
                            <div class="message-meta mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Sent:</strong> {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong>
                                        @if($message->isRead())
                                            <span class="badge badge-success">Read</span>
                                            @if($message->read_at)
                                                on {{ $message->read_at->format('F j, Y \a\t g:i A') }}
                                            @endif
                                        @else
                                            <span class="badge badge-warning">Unread</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="message-content">
                                <h6>Message:</h6>
                                <div class="border rounded p-3 bg-light">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>

                        <!-- Replies Section -->
                        <div class="card-footer">
                            @if($message->replies->count() > 0)
                                <div class="conversation-thread mb-4">
                                    @foreach($message->replies as $reply)
                                        <div class="reply-message mb-3 {{ $reply->sender_type === 'admin' ? 'reply-admin' : 'reply-employee' }}">
                                            <div class="reply-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong>
                                                        @if($reply->sender_type === 'admin')
                                                            <i class="fas fa-user-shield text-primary"></i>
                                                            {{ $reply->sender_name }} (Administrator)
                                                        @else
                                                            <i class="fas fa-user text-info"></i>
                                                            {{ $reply->sender_name }} (Employee)
                                                        @endif
                                                    </strong>
                                                    <small class="text-muted">{{ $reply->created_at->format('M j, Y g:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="reply-content mt-2 p-3 {{ $reply->sender_type === 'admin' ? 'bg-light' : 'bg-info-light' }} rounded">
                                                {{ $reply->reply_content }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted text-center py-3">
                                    <i class="fas fa-comment-slash"></i> No replies yet
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <h6 class="mr-5">
                                <i class="fas fa-reply"></i> Send Reply
                            </h6>
                            <form method="POST" action="{{ route('admin.mailbox.reply', $message) }}">
                                @csrf
                                <div class="form-group">
                                    <textarea name="reply_content" class="form-control" rows="4"
                                            placeholder="Type your reply to {{ $message->employee->name ?? 'the employee' }}..."
                                            required>{{ old('reply_content') }}</textarea>
                                    @error('reply_content')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Reply to: <strong>{{ $message->employee->name ?? 'Unknown Employee' }}</strong></small>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if($message->employee)
                            <div class="card-footer">
                                <h6 class="mb-3">
                                    <i class="fas fa-user"></i> Employee Information
                                </h6>
                                <div class="row">
                                    <div class="ml-5">
                                        <strong>Name:</strong> {{ $message->employee->name }}<br>
                                        <strong>Email:</strong> {{ $message->employee->email ?? 'N/A' }}<br>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Message Details -->
                        <div class="card-footer text-muted">
                            <small>
                                Message ID: {{ $message->id }} |
                                Employee ID: {{ $message->employee_id ?? 'N/A' }} |
                                Created: {{ $message->created_at->format('Y-m-d H:i:s') }}
                                @if($message->read_at)
                                    | Read: {{ $message->read_at->format('Y-m-d H:i:s') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body text-center">
                            <h5>Message Not Found</h5>
                            <p class="text-muted">The requested message could not be found.</p>
                            <a href="{{ route('admin.mailbox.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Back to Mailbox
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
