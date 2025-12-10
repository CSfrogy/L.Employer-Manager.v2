<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Employee Management System | Employee Login</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Employee Management System - Employee Login">

    <link href="{{ secure_asset('main.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ secure_asset('css/auth.css') }}">
</head>

<body class="employee-login">
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3>Employee Portal</h3>
            <p>Employee Management System</p>
        </div>

        <div class="login-body">
            <a href="{{ route('landing') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>

            <div class="alert alert-danger" id="errorAlert"></div>
            <div class="alert alert-success" id="successAlert"></div>

            <form id="loginForm">
                @csrf
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i> Email Address
                    </label>
                    <input name="email" id="email" placeholder="Enter your email" type="email" class="form-control"
                        required>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i> Password
                    </label>
                    <input name="password" id="password" placeholder="Enter your password" type="password"
                        class="form-control" required>
                    <div class="input-icon password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>

                <button type="button" id="loginBtn" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>

            <div class="login-footer">
                <p>
                    <i class="fas fa-info-circle me-2"></i> Don't have an account? 
                    <a href="{{ route('employee.register.view') }}" style="color: #3f6ad8; text-decoration: none; font-weight: 600;">
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        function showAlert(message, type = 'error') {
            const alertDiv = type === 'error' ? document.getElementById('errorAlert') : document.getElementById('successAlert');
            const otherAlert = type === 'error' ? document.getElementById('successAlert') : document.getElementById('errorAlert');
            otherAlert.style.display = 'none';
            alertDiv.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>${message}`;
            alertDiv.style.display = 'block';
        }

        function hideAlerts() {
            document.getElementById('errorAlert').style.display = 'none';
            document.getElementById('successAlert').style.display = 'none';
        }

        document.getElementById('email').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('loginBtn').click();
            }
        });

        document.getElementById('password').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('loginBtn').click();
            }
        });

        document.getElementById('loginBtn').addEventListener('click', function () {
            const btn = this;
            const originalText = btn.innerHTML;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                showAlert('Please fill in all fields.');
                return;
            }

            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
            btn.disabled = true;
            hideAlerts();

            $.ajax({
                url: '{{ route("employee.login") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    password: password
                },
                success: function (response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    } else {
                        showAlert(response.message);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    if (response && response.message) {
                        showAlert(response.message);
                    } else {
                        showAlert('An error occurred. Please try again.');
                    }
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            });
        });
    </script>
</body>

</html>