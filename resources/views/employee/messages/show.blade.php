@extends('layouts.dashboard')

@section('title', 'Message Details')

@section('content')
    <div class="app-main__inner">
        <!-- Page Title -->
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <h1>Message Details</h1>
                        <div class="page-title-subheading">
                            Details of your sent message to administration
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('employee.messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Messages
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(isset($message))
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <!-- Message Header -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="message-info">
                                <h5 class="mb-1">{{ $message->subject }}</h5>
                                <small class="text-muted">
                                    Sent to Administration on {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                </small>
                            </div>

                            <div class="message-actions">
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteMessage({{ $message->id }})">
                                    <i class="fas fa-trash"></i> Delete Message
                                </button>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="card-body">
                            <div class="message-meta mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Sent:</strong> {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong>
                                        @if($message->read_at)
                                            <span class="badge badge-success">Read by Admin</span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $message->read_at->format('F j, Y \a\t g:i A') }}
                                            </small>
                                        @else
                                            <span class="badge badge-warning">Pending Review</span>
                                            <br>
                                            <small class="text-muted">Not yet read by admin</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="message-content">
                                <h6>Your Message:</h6>
                                <div class="border rounded p-3 bg-light">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>


                        @if($message->replies && $message->replies->count() > 0)
                            <div class="card-footer">
                                <div class="conversation-thread">
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
                                                            {{ $reply->sender_name }} (You)
                                                        @endif
                                                    </strong>
                                                    <small class="text-muted">{{ $reply->created_at->format('M j, Y g:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="reply-content mt-2 p-3 {{ $reply->sender_type === 'admin' ? 'bg-primary text-white' : 'bg-light' }} rounded">
                                                {{ $reply->reply_content }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="card-footer">
                            <h6 class="mr-5">
                                <i class="fas fa-reply"></i> Send Reply
                            </h6>
                            <form method="POST" action="{{ route('employee.messages.reply', $message) }}">
                                @csrf
                                <div class="form-group">
                                    <textarea name="reply_content" class="form-control" rows="4"
                                            placeholder="Type your reply to administration..."
                                            required>{{ old('reply_content') }}</textarea>
                                    @error('reply_content')
                                        <small class="text-danger">{{ $errors->first('reply_content') }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Replying to: <strong>Administration</strong></small>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>


                        @if(!$message->read_at)
                            <div class="card-footer">
                                <div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle"></i> Message Status
                                    </h6>
                                    <p class="mb-0">
                                        This message is currently pending review by the administration team.
                                        You will be notified when it has been read and processed.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="card-footer">
                                <div class="alert alert-success" role="alert">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-check-circle"></i> Message Read
                                    </h6>
                                    <p class="mb-0">
                                        This message has been read by the administration team on
                                        {{ $message->read_at->format('F j, Y \a\t g:i A') }}.
                                    </p>
                                </div>
                            </div>
                        @endif


                        <div class="card-footer text-muted">
                            <small>
                                Created: {{ $message->created_at->format('Y-m-d H:i:s') }}
                                @if($message->read_at)
                                    | Read by Admin: {{ $message->read_at->format('Y-m-d H:i:s') }}
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
                            <a href="{{ route('employee.messages.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Back to Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this message? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function deleteMessage(messageId) {
            const form = document.getElementById('deleteForm');
            form.action = `/employee/messages/${messageId}`;


            const deleteModalEl = document.getElementById('deleteModal');
            const modal = new bootstrap.Modal(deleteModalEl);
            modal.show();

            document.getElementById('confirmDelete').onclick = function () {
                form.submit();
            };
        }
    </script>
@endpush

