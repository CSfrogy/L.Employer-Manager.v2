@extends('layouts.dashboard')

@section('title')
    Employee Dashboard
@endsection

@section('content')
        <div class="app-main__inner">

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Welcome, {{ $employee->name }}!</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="mb-2"><strong>Email:</strong> {{ $employee->email }}</p>
                                    <p class="mb-2"><strong>Phone:</strong> {{ $employee->phone }}</p>
                                    <p class="mb-2"><strong>City:</strong> {{ $employee->city }}</p>
                                    <p class="mb-2"><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($employee->dob)->format('M d, Y') }}</p>
                                    <div class="mt-3">
                                        <a href="{{ route('employee.profile.index') }}" class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                                        </a>
                                        <a href="{{ route('employee.tasks.index') }}" class="btn btn-success btn-sm me-2">
                                            <i class="fas fa-tasks me-1"></i> My Tasks
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    @if($employee->image)
                                        <img src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->name }}" class="img-thumbnail" style="max-width: 150px; border-radius: 50%;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=0D8ABC&color=fff&size=150" alt="{{ $employee->name }}" class="img-thumbnail" style="border-radius: 50%;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mb-4">
                @php
                    $taskStats = (new \App\Http\Controllers\Employee\TaskController)->getTaskStats();
                @endphp
                <div class="col-md-3 mb-3">
                    <div class="card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['total_tasks'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-success shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['active_tasks'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-info shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Completed
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['completed_tasks'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-left-warning shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Completion Rate
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['completion_rate'] }}%</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Recent Tasks</h5>
                                <small class="text-muted">Your latest assigned tasks</small>
                            </div>
                            <div>
                                <a href="{{ route('employee.tasks.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i> View All Tasks
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @php
                                $recentTasks = $tasks->take(5);
                            @endphp
                            @if($recentTasks->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Title</th>
                                                <th>Due Date</th>
                                                <th>Priority</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTasks as $task)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $task->title }}</strong>
                                                        @if($task->progress == 100)
                                                            <i class="fas fa-check-circle text-success ms-1" title="Completed"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-calendar me-1 text-muted"></i>
                                                        {{ \Carbon\Carbon::parse($task->date)->format('M d, Y') }}
                                                        @if(\Carbon\Carbon::parse($task->date)->isPast() && $task->status != 2)
                                                            <span class="badge bg-danger ms-1">Overdue</span>
                                                        @elseif(\Carbon\Carbon::parse($task->date)->isToday())
                                                            <span class="badge bg-warning ms-1">Due Today</span>
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
                                                        <div class="progress" style="height: 20px; width: 100px;">
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                    <h5>No tasks assigned</h5>
                                    <p class="text-muted">You don't have any tasks assigned yet.</p>
                                    <a href="{{ route('employee.tasks.index') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Check Task List
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            console.log('Employee dashboard script loaded');

    
            $('.table').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Filter records:",
                    "lengthMenu": "Show _MENU_ entries per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                }
            });

            setTimeout(function () {
                $('.alert').fadeOut(300);
            }, 5000);
        });
    </script>
@endsection
