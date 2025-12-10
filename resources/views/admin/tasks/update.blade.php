@extends('admin.layouts.app')

@section('title')
    Update Task
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Task Update</h5>
                                <form class="" id="update_task">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">List of Employee</label>
                                        <select name="employee" id="employee" class="form-control">
                                            <option value="">Select Employee</option>
                                            @forelse ($employees as $employee)
                                                @if ($employee->id == $task->emp_id)
                                                    @php
                                                        $selected = 'selected';
                                                    @endphp
                                                @else
                                                    @php
                                                        $selected = '';
                                                    @endphp
                                                @endif
                                                <option value="{{ $employee->id }}" {{ $selected }}>
                                                    {{ $employee->name }}
                                                </option>

                                            @empty
                                                <option value="">Employee list not found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Title</label>
                                        <input name="title" id="title" value="{{ $task->title }}"
                                            placeholder="Enter Your Title" type="text" class="form-control">
                                        <input name="id" id="id" value="{{ $task->id }}" placeholder="Enter Your Title"
                                            type="hidden" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Content/Description</label>
                                        <textarea name="content" id="content" class="form-control" cols="30"
                                            rows="10">{{ $task->content }}</textarea>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Publish Date</label>
                                        <input name="date" id="date" value="{{ $task->date }}" placeholder="" type="date"
                                            class="form-control">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Status</label>
                                        <select name="status" value="{{ $task->status }}" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Update</button>
                                    <a href="{{ route('admin.task.list') }}" class="mt-1 btn btn-secondary">Cancel</a>

                                    <!-- Message area under buttons -->
                                    <div id="message-area" class="mt-3" style="display: none;"></div>
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
        $("#update_task").submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.text('Updating...').prop('disabled', true);

            // Clear previous messages
            $('#message-area').hide().removeClass('alert-success alert-danger');

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.task.update') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {
                    submitBtn.text(originalText).prop('disabled', false);

                    if (data.success == true) {
                        // Show success message under buttons
                        showMessage('success', data.message);

                        // Redirect to task list after 1.5 seconds
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.task.list') }}";
                        }, 1500);
                    } else {
                        // Show error message under buttons
                        showMessage('error', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.text(originalText).prop('disabled', false);

                    // Show error message under buttons
                    showMessage('error', 'An error occurred while updating the task');
                }
            });
        });

        function showMessage(type, message) {
            const messageArea = $('#message-area');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? '✓' : '✗';

            messageArea.html(`
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <strong>${iconClass} ${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `).show();
        }
    </script>
@endsection
