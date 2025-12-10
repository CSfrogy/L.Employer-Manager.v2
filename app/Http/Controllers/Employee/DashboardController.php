<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $employee = Auth::guard('employee')->user();
        $tasks = $employee->tasks()->latest()->get();

        return view('employee.dashboard', [
            'employee' => $employee,
            'tasks' => $tasks,
            'user' => $employee,
            'userRole' => 'employee'
        ]);
    }
}
