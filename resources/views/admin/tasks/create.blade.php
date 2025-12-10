@extends('admin.layouts.app')

@section('title')
    Create Task
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Task Create</h5>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.task.create') }}" id="create_task">
                                    @csrf
                                    <div class="position-relative form-group">
                                        <label for="employee" class="">List of Employee</label>
                                        <select name="employee" id="employee" class="form-control">
                                            <option value="">Select Employee</option>
                                            @forelse ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ (old('employee') == $employee->id || request('employee_id') == $employee->id) ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
                                            @empty
                                                <option value="">Employee list not found</option>
                                            @endforelse
                                        </select>
                                        @error('employee')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="title" class="">Title</label>
                                        <input name="title" id="title" placeholder="Enter Your Title" type="text"
                                            class="form-control" value="{{ old('title') }}">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="content" class="">Content/Description</label>
                                        <textarea name="content" id="content" class="form-control" cols="30"
                                            rows="10">{{ old('content') }}</textarea>
                                        @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="date" class="">Publish Date</label>
                                        <input name="date" id="date" type="date" class="form-control"
                                            value="{{ old('date') }}">
                                        @error('date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="status" class="">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary" id="submit_btn">Create</button>
                                    <a href="{{ route('admin.task.list') }}" class="mt-1 btn btn-secondary">Cancel</a>
                                </form>
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
            $('#create_task').on('submit', function () {
                $('#submit_btn').html('<i class="fas fa-spinner fa-spin"></i> Creating...');
                $('#submit_btn').prop('disabled', true);
            });
        });
    </script>
@endsection