@extends('layouts.dashboard')

@section('title')
    My Tasks
@endsection

@section('content')
    <div class="app-main__inner">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">My Tasks</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form method="GET" action="{{ route('employee.tasks.index') }}">
                                    <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                   placeholder="Search tasks..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <div class="filter-buttons float-end">
                                        <a href="{{ route('employee.tasks.index') }}"
                                           class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fas fa-list me-1"></i> All Tasks
                                        </a>
                                        <a href="{{ route('employee.tasks.index', ['status' => '1']) }}"
                                           class="btn btn-sm {{ request('status') == '1' ? 'btn-success' : 'btn-outline-success' }}">
                                            <i class="fas fa-play me-1"></i> Active
                                        </a>
                                        <a href="{{ route('employee.tasks.index', ['status' => '2']) }}"
                                           class="btn btn-sm {{ request('status') == '2' ? 'btn-info' : 'btn-outline-info' }}">
                                            <i class="fas fa-check me-1"></i> Completed
                                        </a>
                                        <a href="{{ route('employee.tasks.index', ['status' => '3']) }}"
                                           class="btn btn-sm {{ request('status') == '3' ? 'btn-warning' : 'btn-outline-warning' }}">
                                            <i class="fas fa-pause me-1"></i> On Hold
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Due Date</th>
                                            <th>Priority</th>
                                            <th>Progress</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tasks as $task)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $task->title }}</strong>
                                                    @if($task->progress == 100)
                                                        <i class="fas fa-check-circle text-success ms-1" title="Completed"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span title="{{ $task->content }}">
                                                        {{ Str::limit($task->content, 50) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                                    {{ \Carbon\Carbon::parse($task->date)->format('M d, Y') }}
                                                    @if(\Carbon\Carbon::parse($task->date)->isPast() && $task->status != 2)
                                                        <span class="badge bg-danger ms-1">Overdue</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $priorityLabels = [1 => 'High', 2 => 'Medium', 3 => 'Normal', 4 => 'Low', 5 => 'Very Low'];
                                                        $priorityColors = [1 => 'danger', 2 => 'warning', 3 => 'info', 4 => 'secondary', 5 => 'light'];
                                                    @endphp
                                                    <span class="badge bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                                                        {{ $priorityLabels[$task->priority] ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{ $task->progress }}%"
                                                             aria-valuenow="{{ $task->progress }}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                            {{ $task->progress }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $task->status == 1 ? 'bg-success' : ($task->status == 2 ? 'bg-info' : ($task->status == 3 ? 'bg-warning' : 'bg-secondary')) }}">
                                                        <i class="fas fa-{{ $task->status == 1 ? 'play' : ($task->status == 2 ? 'check' : ($task->status == 3 ? 'pause' : 'stop')) }} me-1"></i>
                                                        {{ $task->status == 1 ? 'Active' : ($task->status == 2 ? 'Completed' : ($task->status == 3 ? 'On Hold' : 'Inactive')) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('employee.tasks.show', $task->id) }}"
                                                       class="btn btn-primary btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                                    <h5>No tasks found</h5>
                                                    <p class="text-muted">
                                                        @if(request('search'))
                                                            No tasks match your search criteria.
                                                        @elseif(request('status'))
                                                            No {{ request('status') == 1 ? 'active' : (request('status') == 2 ? 'completed' : (request('status') == 3 ? 'on hold' : 'inactive')) }} tasks available.
                                                        @else
                                                            You don't have any tasks assigned yet.
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $tasks->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            console.log('Employee tasks script loaded');

            $('.alert').click(function () {
                $(this).fadeOut(300);
            });
        });
    </script>
@endsection
