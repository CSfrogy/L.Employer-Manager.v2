@extends('admin.layouts.app')

@section('title')
    Update Employee
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Employee Update</h5>
                                <form class="" id="update_emp">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Name</label>
                                        <input name="name" value="{{ $employee->name }}" id="emp_name" placeholder="Enter Your Name" type="text"
                                            class="form-control">
                                            <input name="id" value="{{ $employee->id }}" id="id" placeholder="Enter Your Name" type="hidden"
                                            class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Email</label>
                                        <input name="email" value="{{ $employee->email }}" id="emp_email" placeholder="Enter Your Email" type="email"
                                            class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Date of Birth</label>
                                        <input name="dob" value="{{ $employee->dob }}" id="emp_dob" placeholder="Enter Your Date of Birth"
                                            type="text" class="form-control">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Phone</label>
                                        <input name="phone" value="{{ $employee->phone }}" id="emp_phone" placeholder="Enter Your Phone" type="text"
                                            class="form-control">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">City</label>
                                        <input name="city" value="{{ $employee->city }}" id="emp_city" placeholder="Enter Your City" type="text"
                                            class="form-control">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Image</label>
                                        <input name="image" id="emp_image" type="file" class="form-control">
                                        <img src="{{ asset('storage') }}/{{  $employee->image }}" width="60" alt="">
                                        <input name="old_image" id="emp_image" type="hidden"  value="{{  $employee->image }}" class="form-control">
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Update</button>
                                    <a href="{{ route('admin.employee.list') }}" class="mt-1 btn btn-secondary">Cancel</a>

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
        $("#update_emp").submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.text('Updating...').prop('disabled', true);

            $('#message-area').hide().removeClass('alert-success alert-danger');

            $.ajax({
                type: 'POST',
                url: '{{ route("admin.employee.update") }}',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {
                    submitBtn.text(originalText).prop('disabled', false);

                    if (data.success == true) {
                        showMessage('success', Array.isArray(data.message) ? data.message[0] : data.message);

                        setTimeout(function() {
                            window.location.href = "{{ route('admin.employee.list') }}";
                        }, 1500);
                    } else {
                        const errorMessage = Array.isArray(data.message) ? data.message[0] : data.message;
                        showMessage('error', errorMessage);
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.text(originalText).prop('disabled', false);

                    showMessage('error', 'An error occurred while updating the employee');
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
