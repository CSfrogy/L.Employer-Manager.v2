@extends('admin.layouts.app')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="row">
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Employees
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployees ?? 0 }}</div>
                                    <div class="text-muted">All Team Members</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-left-info shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTasks ?? 0 }}</div>
                                    <div class="text-muted">All Tasks</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-left-success shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeTasks ?? 0 }}</div>
                                    <div class="text-muted">Currently Active</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-left-warning shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Inactive Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inactiveTasks ?? 0 }}</div>
                                    <div class="text-muted">Currently Inactive</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
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
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-light me-2 toggle-section" data-target="task-section">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div>
                                    <h5 class="card-title mb-0">Task Management</h5>
                                    <small class="text-muted">Manage and filter tasks by status</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.task.add') }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Add New Task
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body task-section">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="filter-buttons">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fas fa-list me-1"></i> All Tasks ({{ $totalTasks ?? 0 }})
                                        </a>
                                        <a href="{{ route('admin.dashboard', ['status' => 'active']) }}"
                                            class="btn btn-sm {{ $status === 'active' ? 'btn-success' : 'btn-outline-success' }}">
                                            <i class="fas fa-play-circle me-1"></i> Active ({{ $activeTasks ?? 0 }})
                                        </a>
                                        <a href="{{ route('admin.dashboard', ['status' => 'inactive']) }}"
                                            class="btn btn-sm {{ $status === 'inactive' ? 'btn-danger' : 'btn-outline-danger' }}">
                                            <i class="fas fa-pause-circle me-1"></i> Inactive ({{ $inactiveTasks ?? 0 }})
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <form method="GET" action="{{ route('admin.dashboard') }}">
                                        <div class="input-group">
                                            <input type="text" name="task_search" class="form-control"
                                                placeholder="Search tasks..." value="{{ request('task_search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        @if(request('status'))
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Assigned Employee</th>
                                            <th>Content</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tasks as $task)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $task->title }}</strong>
                                                </td>
                                                <td>
                                                    @if($task->employee)
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($task->employee->name) }}&background=0D8ABC&color=fff"
                                                                alt="{{ $task->employee->name }}" class="rounded-circle me-2"
                                                                width="32" height="32">
                                                            <div>
                                                                <strong>{{ $task->employee->name }}</strong>
                                                                <div class="text-muted small">{{ $task->employee->email }}</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No employee assigned</span>
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
                                                </td>
                                                <td>
                                                    <span class="badge {{ $task->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        <i class="fas fa-{{ $task->status == 1 ? 'play' : 'pause' }} me-1"></i>
                                                        {{ $task->status == 1 ? 'Active' : 'Paused' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $task->created_at->format('M d, Y') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.task.edit', $task->id) }}"
                                                            class="btn btn-warning btn-sm" title="Edit Task">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('admin.task.delete.from.dashboard') }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $task->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this task?')"
                                                                title="Delete Task">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                                    <h5>No tasks found</h5>
                                                    <p class="text-muted">
                                                        @if($status !== 'all')
                                                            No {{ $status }} tasks available.
                                                        @else
                                                            No tasks have been created yet.
                                                        @endif
                                                    </p>
                                                    <a href="{{ route('admin.task.add') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i> Create First Task
                                                    </a>
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

        
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-light me-2 toggle-section" data-target="employee-section">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div>
                                    <h5 class="card-title mb-0">Employee Management</h5>
                                    <small class="text-muted">Manage your team members and their tasks</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.employee.add') }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Add New Employee
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body employee-section">
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
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <form method="GET" action="{{ route('admin.dashboard') }}">
                                        <div class="input-group">
                                            <input type="text" name="employee_search" class="form-control"
                                                placeholder="Search employees..." value="{{ request('employee_search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Date of Birth</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employees as $employee)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($employee->image)
                                                            <img src="{{ asset('storage/' . $employee->image) }}"
                                                                alt="{{ $employee->name }}" class="rounded-circle me-3" width="40"
                                                                height="40"
                                                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=0D8ABC&color=fff'">
                                                        @else
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=0D8ABC&color=fff"
                                                                alt="{{ $employee->name }}" class="rounded-circle me-3" width="40"
                                                                height="40">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $employee->name }}</strong>
                                                            <div class="text-muted small">Joined:
                                                                {{ $employee->created_at->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $employee->email }}</td>
                                                <td>{{ $employee->phone }}</td>
                                                <td>{{ $employee->city }}</td>
                                                <td>{{ \Carbon\Carbon::parse($employee->dob)->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge bg-success">Active</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.employee.edit', $employee->id) }}"
                                                            class="btn btn-warning btn-sm" title="Edit Employee">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.task.add') }}?employee_id={{ $employee->id }}"
                                                            class="btn btn-primary btn-sm" title="Assign Task">
                                                            <i class="fas fa-tasks"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('admin.employee.delete.from.dashboard') }}"
                                                            style="display: inline;"
                                                            onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $employee->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                title="Delete Employee">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                    <h5>No employees found</h5>
                                                    <p class="text-muted">No employees have been added yet.</p>
                                                    <a href="{{ route('admin.employee.add') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i> Add First Employee
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $employees->links('pagination::bootstrap-5') }}
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
            console.log('Dashboard script loaded');

            const savedStates = JSON.parse(localStorage.getItem('dashboardSectionStates')) || {
                'task-section': true,
                'employee-section': false
            };

            Object.keys(savedStates).forEach(sectionClass => {
                const section = $('.' + sectionClass);
                const icon = $(`.toggle-section[data-target="${sectionClass}"]`).find('i');
                if (savedStates[sectionClass]) {
                    section.show();
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    section.hide();
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
            });

            $('.toggle-section').click(function (e) {
                e.preventDefault();
                const target = $(this).data('target');
                const section = $('.' + target);
                const icon = $(this).find('i');

                if (section.is(':visible')) {
                    section.slideUp(300);
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    savedStates[target] = false;
                } else {
                    section.slideDown(300);
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    savedStates[target] = true;
                }

                localStorage.setItem('dashboardSectionStates', JSON.stringify(savedStates));
            });

            setTimeout(function () {
                $('.alert').fadeOut(300);
            }, 5000);

            $('.alert').click(function () {
                $(this).fadeOut(300);
            });
        });
    </script>

    <style>
        .toggle-section {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            background: white;
            transition: all 0.2s ease;
        }

        .toggle-section:hover {
            background: #f8f9fa;
        }

        .toggle-section i {
            transition: transform 0.3s ease;
        }

        .rounded-circle {
            object-fit: cover;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .pagination {
            justify-content: center;
            margin-top: 15px;
        }

        .page-link {
            border-radius: 6px !important;
        }
    </style>
@endsection
