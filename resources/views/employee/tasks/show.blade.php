@extends('layouts.dashboard')

@section('title')
    Task Details
@endsection

@section('content')
    <div class="app-main__inner">
        <div class="row">
            <div class="col-md-8">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ $task->title }}</h5>
                            <a href="{{ route('employee.tasks.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to Tasks
                            </a>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <strong>Due Date:</strong>
                                    <div class="mt-1">
                                        <i class="fas fa-calendar me-1 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($task->date)->format('M d, Y') }}
                                        @if(\Carbon\Carbon::parse($task->date)->isPast() && $task->status != 2)
                                            <span class="badge bg-danger ms-2">Overdue</span>
                                        @elseif(\Carbon\Carbon::parse($task->date)->isToday())
                                            <span class="badge bg-warning ms-2">Due Today</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Priority:</strong>
                                    <div class="mt-1">
                                        @php
                                            $priorityLabels = [1 => 'High', 2 => 'Medium', 3 => 'Normal', 4 => 'Low', 5 => 'Very Low'];
                                            $priorityColors = [1 => 'danger', 2 => 'warning', 3 => 'info', 4 => 'secondary', 5 => 'light'];
                                        @endphp
                                        <span class="badge bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                                            {{ $priorityLabels[$task->priority] ?? 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <strong>Description:</strong>
                                <div class="mt-2 p-3 bg-light rounded">
                                    {{ $task->content }}
                                </div>
                            </div>

                            @if($task->notes)
                                <div class="mb-4">
                                    <strong>My Notes:</strong>
                                    <div class="mt-2 p-3 bg-light rounded">
                                        {{ $task->notes }}
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <strong>Progress:</strong>
                                <div class="mt-2">
                                    <div class="progress mb-2" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{ $task->progress }}%"
                                             aria-valuenow="{{ $task->progress }}"
                                             aria-valuemin="0" aria-valuemax="100">
                                            {{ $task->progress }}% Complete
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <strong>Current Status:</strong>
                                <div class="mt-1">
                                    <span class="badge {{ $task->status == 1 ? 'bg-success' : ($task->status == 2 ? 'bg-info' : ($task->status == 3 ? 'bg-warning' : 'bg-secondary')) }} fs-6">
                                        <i class="fas fa-{{ $task->status == 1 ? 'play' : ($task->status == 2 ? 'check' : ($task->status == 3 ? 'pause' : 'stop')) }} me-1"></i>
                                        {{ $task->status == 1 ? 'Active' : ($task->status == 2 ? 'Completed' : ($task->status == 3 ? 'On Hold' : 'Inactive')) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Status</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('employee.tasks.update-status', $task->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" {{ $task->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ $task->status == 2 ? 'selected' : '' }}>Completed</option>
                                        <option value="3" {{ $task->status == 3 ? 'selected' : '' }}>On Hold</option>
                                        <option value="0" {{ $task->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"
                                              placeholder="Add any notes about this status change...">{{ old('notes') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Progress</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('employee.tasks.update-progress', $task->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="progress" class="form-label">Progress Percentage</label>
                                    <input type="range" class="form-range" id="progress" name="progress"
                                           min="0" max="100" value="{{ $task->progress }}"
                                           oninput="updateProgressDisplay(this.value)">
                                    <div class="text-center mt-2">
                                        <span class="badge bg-primary fs-6" id="progress-display">{{ $task->progress }}%</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Progress Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"
                                              placeholder="Describe your progress...">{{ old('notes') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-chart-line me-1"></i> Update Progress
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Request Extension</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('employee.tasks.extension', $task->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3"
                                              placeholder="Explain why you need an extension..." required>{{ old('reason') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="new_date" class="form-label">New Due Date</label>
                                    <input type="date" class="form-control" id="new_date" name="new_date"
                                           min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-clock me-1"></i> Request Extension
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        function updateProgressDisplay(value) {
            document.getElementById('progress-display').textContent = value + '%';
        }

        $(document).ready(function () {
            console.log('Task details script loaded');

            $('.alert').click(function () {
                $(this).fadeOut(300);
            });
        });
    </script>
@endsection
