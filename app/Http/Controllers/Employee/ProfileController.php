<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        $employee = Auth::guard('employee')->user();
        return view('employee.profile.index', [
            'employee' => $employee,
            'user' => $employee,
            'userRole' => 'employee',
        ]);
    }

    public function update(Request $request)
    {
        $currentEmployee = Auth::guard('employee')->user();
        $employee = \App\Models\Employee::findOrFail($currentEmployee->id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->city = $request->city;
        $employee->dob = $request->dob;

        $result = $employee->save();

        if ($result) {
            return redirect()->route('employee.profile.index')
                ->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $currentEmployee = Auth::guard('employee')->user();
        $employee = \App\Models\Employee::findOrFail($currentEmployee->id);

        $validation = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        if (!Hash::check($request->current_password, $employee->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.')
                ->withInput();
        }

        $employee->password = Hash::make($request->new_password);
        $result = $employee->save();

        if ($result) {
            return redirect()->route('employee.profile.index')
                ->with('success', 'Password updated successfully');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update password. Please try again.')
                ->withInput();
        }
    }

    public function uploadImage(Request $request)
    {
        $currentEmployee = Auth::guard('employee')->user();
        $employee = \App\Models\Employee::findOrFail($currentEmployee->id);

        $validation = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:1024',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }


        if ($employee->image) {
            $oldPath = public_path('storage/' . $employee->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }


        $filename = $request->file('image')->store('employee', 'public');
        $employee->image = $filename;
        $result = $employee->save();

        if ($result) {
            return redirect()->route('employee.profile.index')
                ->with('success', 'Profile image updated successfully.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update profile image. Please try again.')
                ->withInput();
        }
    }
}
