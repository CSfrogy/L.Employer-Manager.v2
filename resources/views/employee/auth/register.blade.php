<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Employee Management System | Employee Registration</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Employee Management System - Employee Registration">

    <link href="{{ secure_asset('main.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ secure_asset('css/auth.css') }}">
</head>

<body class="employee-login">
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>Create Account</h3>
            <p>Employee Management System</p>
        </div>

        <div class="login-body">
            <a href="{{ route('landing') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>

            <div class="alert alert-danger" id="errorAlert"></div>
            <div class="alert alert-success" id="successAlert"></div>

            <form id="registerForm">
                @csrf
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i> Full Name
                    </label>
                    <input name="name" id="name" placeholder="Enter your full name" type="text" class="form-control"
                        required>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i> Phone Number
                    </label>
                    <input name="phone" id="phone" placeholder="Enter your phone number" type="tel" class="form-control"
                        required>
                    <div class="input-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i> Email Address
                    </label>
                    <input name="email" id="email" placeholder="Enter your email" type="email" class="form-control"
                        required>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob" class="form-label">
                        <i class="fas fa-calendar me-2"></i> Date of Birth
                    </label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                        <select name="dob_day" id="dob_day" class="form-control" required>
                            <option value="">Day</option>
                            <script>
                                for(let i = 1; i <= 31; i++) {
                                    document.write(`<option value="${i.toString().padStart(2, '0')}">${i}</option>`);
                                }
                            </script>
                        </select>
                        <select name="dob_month" id="dob_month" class="form-control" required>
                            <option value="">Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="dob_year" id="dob_year" class="form-control" required>
                            <option value="">Year</option>
                            <script>
                                const currentYear = new Date().getFullYear();
                                const minYear = currentYear - 18;
                                const maxYear = currentYear - 80;
                                for(let i = minYear; i >= maxYear; i--) {
                                    document.write(`<option value="${i}">${i}</option>`);
                                }
                            </script>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i> Password
                    </label>
                    <input name="password" id="password" placeholder="Create a password" type="password"
                        class="form-control" required>
                    <div class="input-icon password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-2"></i> Confirm Password
                    </label>
                    <input name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" 
                        type="password" class="form-control" required>
                    <div class="input-icon password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>

                <button type="button" id="registerBtn" class="btn-login">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
            </form>

            <div class="login-footer">
                <p>
                    <i class="fas fa-info-circle me-2"></i> Already have an account? 
                    <a href="{{ route('employee.auth.login') }}" style="color: #3f6ad8; text-decoration: none; font-weight: 600;">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.parentElement.querySelector('.password-toggle i');

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

        ['name', 'phone', 'email', 'password', 'password_confirmation'].forEach(fieldId => {
            document.getElementById(fieldId).addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    document.getElementById('registerBtn').click();
                }
            });
        });

        document.getElementById('registerBtn').addEventListener('click', function () {
            const btn = this;
            const originalText = btn.innerHTML;
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
        
            const dobDay = document.getElementById('dob_day').value;
            const dobMonth = document.getElementById('dob_month').value;
            const dobYear = document.getElementById('dob_year').value;
            const dob = dobYear && dobMonth && dobDay ? `${dobYear}-${dobMonth}-${dobDay}` : '';
            
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validation
            if (!name || !phone || !email || !dob || !password || !passwordConfirmation) {
                showAlert('Please fill in all fields.');
                return;
            }

            if (password !== passwordConfirmation) {
                showAlert('Passwords do not match.');
                return;
            }

            if (password.length < 6) {
                showAlert('Password must be at least 6 characters long.');
                return;
            }

            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
            btn.disabled = true;
            hideAlerts();

            $.ajax({
                url: '{{ route("employee.register") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    phone: phone,
                    email: email,
                    dob: dob,
                    password: password,
                    password_confirmation: passwordConfirmation
                },
                success: function (response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1500);
                    } else {
                        showAlert(response.message);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    if (response && response.errors) {
                        // Handle validation errors
                        const errorMessages = Object.values(response.errors).flat();
                        showAlert(errorMessages.join(' '));
                    } else if (response && response.message) {
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