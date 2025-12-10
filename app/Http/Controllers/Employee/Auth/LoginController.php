<?php
<<<<<<< HEAD

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
=======
namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
>>>>>>> 915461f (commit)

class LoginController extends Controller
{
    public function index(): View
    {
        return view("employee.auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials)) {
            $request->session()->regenerate();
<<<<<<< HEAD

=======
>>>>>>> 915461f (commit)
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('employee.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials. Please try again.'
        ], 401);
    }

<<<<<<< HEAD
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

=======
    // Registration methods
    public function showRegisterForm(): View
    {
        return view("employee.auth.register");
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:employees,email',
            'dob' => 'required|date|before:today',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter your phone number.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'dob.required' => 'Please enter your date of birth.',
            'dob.date' => 'Please enter a valid date.',
            'dob.before' => 'Date of birth must be in the past.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create new employee
            $employee = Employee::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'dob' => $request->dob,
                'password' => Hash::make($request->password),
                'image' => 'default.png',
                'city' => 'Not Specified'
            ]);

            // Auto-login after registration
            Auth::guard('employee')->login($employee);
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully! Redirecting to dashboard...',
                'redirect' => route('employee.dashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
>>>>>>> 915461f (commit)
        return redirect()->route('employee.auth.login');
    }
}