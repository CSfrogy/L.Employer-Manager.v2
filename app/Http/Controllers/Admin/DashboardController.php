<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request){
    $status = $request->get('status', 'all');
    $taskSearch = $request->get('task_search');
    $employeeSearch = $request->get('employee_search');

    $taskQuery = Task::with('employee')->latest();

    if ($status === 'active') {
        $taskQuery->where('status', 1);
    } elseif ($status === 'inactive') {
        $taskQuery->where('status', 0);
    }

    if ($taskSearch) {
        $taskQuery->where(function($query) use ($taskSearch) {
            $query->where('title', 'like', "%{$taskSearch}%")
                  ->orWhere('content', 'like', "%{$taskSearch}%")
                  ->orWhereHas('employee', function($q) use ($taskSearch) {
                      $q->where('name', 'like', "%{$taskSearch}%");
                  });
        });
    }

    $tasks = $taskQuery->paginate(10)->appends($request->except('page'));

    $totalTasks = Task::count();
    $activeTasks = Task::where('status', 1)->count();
    $inactiveTasks = Task::where('status', 0)->count();

    $employeeQuery = Employee::latest();

    if ($employeeSearch) {
        $employeeQuery->where(function($query) use ($employeeSearch) {
            $query->where('name', 'like', "%{$employeeSearch}%")
                  ->orWhere('email', 'like', "%{$employeeSearch}%")
                  ->orWhere('phone', 'like', "%{$employeeSearch}%")
                  ->orWhere('city', 'like', "%{$employeeSearch}%");
        });
    }

    $employees = $employeeQuery->paginate(10)->appends($request->except('page'));

    $totalEmployees = Employee::count();

    return view('admin.dashboard', [
        'tasks' => $tasks,
        'totalTasks' => $totalTasks,
        'activeTasks' => $activeTasks,
        'inactiveTasks' => $inactiveTasks,
        'totalEmployees' => $totalEmployees,
        'employees' => $employees,
        'status' => $status,
        'userRole' => 'admin'
    ]);
}

}
