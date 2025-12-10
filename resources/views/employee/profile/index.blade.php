@extends('layouts.dashboard')

@section('title')
    My Profile
@endsection

@section('content')
    <div class="app-main__inner">
        <div class="row">
            <div class="col-md-8">
             
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
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

                        <form method="POST" action="{{ route('employee.profile.update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name', $employee->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $employee->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $employee->phone) }}" required>
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                           value="{{ old('city', $employee->city) }}" required>
                                    @error('city')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob"
                                           value="{{ old('dob', $employee->dob) }}" required>
                                    @error('dob')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="member_since" class="form-label">Member Since</label>
                                    <input type="text" class="form-control"
                                           value="{{ $employee->created_at->format('M d, Y') }}" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('employee.profile.update-password') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password"
                                       name="current_password" required>
                                @error('current_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password"
                                       name="new_password" required>
                                @error('new_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                       name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-1"></i> Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Picture</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($employee->image)
                                <img src="{{ asset('storage/' . $employee->image) }}"
                                     alt="{{ $employee->name }}"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=0D8ABC&color=fff&size=150"
                                     alt="{{ $employee->name }}"
                                     class="img-thumbnail rounded-circle">
                            @endif
                        </div>
                        <form method="POST" action="{{ route('employee.profile.upload-image') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" id="image" name="image"
                                       accept="image/*" required>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-camera me-1"></i> Upload New Picture
                            </button>
                        </form>
                    </div>
                </div>

                
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">My Statistics</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $taskStats = (new \App\Http\Controllers\Employee\TaskController)->getTaskStats();
                        @endphp
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h4 class="text-primary mb-0">{{ $taskStats['total_tasks'] }}</h4>
                                    <small class="text-muted">Total Tasks</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h4 class="text-success mb-0">{{ $taskStats['completed_tasks'] }}</h4>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h4 class="text-info mb-0">{{ $taskStats['active_tasks'] }}</h4>
                                    <small class="text-muted">Active</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h4 class="text-warning mb-0">{{ $taskStats['overdue_tasks'] }}</h4>
                                    <small class="text-muted">Overdue</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h6>Completion Rate</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $taskStats['completion_rate'] }}%"
                                     aria-valuenow="{{ $taskStats['completion_rate'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    {{ $taskStats['completion_rate'] }}%
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
            console.log('Profile script loaded');

            $('.alert').click(function () {
                $(this).fadeOut(300);
            });
        });
    </script>
@endsection
