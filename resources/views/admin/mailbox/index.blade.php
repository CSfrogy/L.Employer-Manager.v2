@extends('admin.layouts.app')

@section('title', 'Mailbox - Employee Messages')

@push('styles')
<style>
.message-content {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 25px 30px;
    margin: 20px 25px;
    border-radius: 8px;
    white-space: pre-wrap;
    line-height: 1.6;
    font-size: 15px;
    color: #495057;
}

.enhanced-card-body {
    padding: 32px 36px;
}

.admin-table td {
    padding: 18px 14px;
    vertical-align: top;
}

.admin-table td:first-child {
    padding-left: 24px;
}

.admin-table td:last-child {
    padding-right: 24px;
}

.employee-info {
    line-height: 1.6;
    margin-bottom: 10px;
}

.subject-link {
    line-height: 1.5;
    font-size: 0.95rem;
}

.admin-btn-group .btn {
    margin-right: 6px;
    margin-bottom: 6px;
    padding: 6px 12px;
}

.admin-btn-group .btn:last-child {
    margin-right: 0;
}

.card-header {
    padding: 20px 24px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.pagination-wrapper {
    margin-top: 32px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.empty-state {
    padding: 48px 24px;
}
</style>
@endpush

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h1>Mailbox</h1>
                        <div class="page-title-subheading">
                            View and manage messages from employees
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="badge badge-pill badge-primary">
                        {{ $unreadCount }} Unread
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h4>Messages from Employees</h4>
                    </div>
                    <div class="card-body enhanced-card-body">
                        @if($messages->count() > 0)
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover admin-table">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>From</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($messages as $message)
                                        <tr class="{{ !$message->isRead() ? 'font-weight-bold bg-light' : '' }}">
                                            <td>
                                                @if(!$message->isRead())
                                                    <span class="badge badge-primary">Unread</span>
                                                @else
                                                    <span class="badge badge-secondary">Read</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="employee-info">
                                                    <strong>{{ $message->employee->name ?? 'Unknown Employee' }}</strong>
                                                </div>
                                                <div>
                                                    <small class="text-muted">{{ $message->employee->email ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="subject-link">
                                                    <a href="{{ route('admin.mailbox.show', $message) }}"
                                                       class="text-decoration-none">
                                                        {{ \Illuminate\Support\Str::limit($message->subject, 50) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ $message->created_at->format('M j, Y g:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="admin-btn-group">
                                                    <a href="{{ route('admin.mailbox.show', $message) }}"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.mailbox.destroy', $message) }}" style="display: inline-block;">
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
                            <div class="pagination-wrapper">
                                {{ $messages->links() }}
                            </div>
                        @else
                            <div class="text-center empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No messages yet</h5>
                                <p class="text-muted">Employee messages will appear here when they contact you.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
