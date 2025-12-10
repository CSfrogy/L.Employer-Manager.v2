<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>L.Employee Management System</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Employee Management System - Choose your login type">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if(!file_exists(public_path('build/manifest.json')))
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">
    @endif
</head>

<body class="landing-page">
    <div class="landing-body">
        <div class="content-wrapper">
            <div class="welcome-section">
                <div class="welcome-content">
                    <h2>Access Control</h2>
                    <p>Please select your access level to continue</p>
                </div>
            </div>

            <div class="login-section">
                <a href="{{ route('employee.auth.login') }}" class="access-button employee-btn">
                    <span>Enter Employee Portal</span>
                </a>
                <a href="{{ route('admin.auth.login') }}" class="access-button admin-btn">
                    <span>Enter Admin Panel</span>
                </a>
            </div>




            <div class="footer-section">
                <div class="system-footer">
                    <div class="company-info">
                        <span class="company-name">L.Employer Manager System</span>
                    </div>
                    <div class="footer-links">
                        <span>© 2025</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
