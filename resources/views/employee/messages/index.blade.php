@extends('layouts.dashboard')

@section('title', 'Messages - Sent to Administration')

@push('styles')
    <style>
        .table td {
            padding: 16px 12px;
            vertical-align: top;
        }

        .table td:first-child {
            padding-left: 20px;
        }

        .table td:last-child {
            padding-right: 20px;
        }

        .message-preview {
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .message-meta {
            line-height: 1.4;
            font-size: 0.875rem;
        }

        .status-section {
            line-height: 1.4;
        }

        .btn-group .btn {
            margin-right: 4px;
            margin-bottom: 4px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>
@endpush

@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <h1>Messages</h1>
                        <div class="page-title-subheading">
                            Send messages to administration and view your sent messages
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('employee.messages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Message
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

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h4>Your Sent Messages</h4>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <div class="btn-group">
                                <div class="badge badge-pill badge-primary">
                                    {{ $sentCount }} Total Sent
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($messages->count() > 0)
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Sent Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($messages as $message)
                                            <tr>
                                                <td>
                                                    <div class="message-preview">
                                                        <strong>{{ \Illuminate\Support\Str::limit($message->subject, 50) }}</strong>
                                                    </div>
                                                    <div class="message-meta">
                                                        <small class="text-muted">
                                                            {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="message-meta">
                                                        <small>{{ $message->created_at->format('M j, Y g:i A') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-section">
                                                        @if($message->read_at)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-eye"></i> Read by Admin
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $message->read_at->format('M j, Y g:i A') }}
                                                            </small>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-clock"></i> Pending
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('employee.messages.show', $message) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <form method="POST" action="{{ route('employee.messages.destroy', $message) }}" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this message?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $messages->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No messages sent yet</h5>
                                <p class="text-muted">Click "New Message" to send your first message to administration.</p>
                                <a href="{{ route('employee.messages.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Send Your First Message
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
