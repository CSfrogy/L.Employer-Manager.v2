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

    // Task query with eager loading and selective columns
    $taskQuery = Task::select('id', 'emp_id', 'title', 'content', 'date', 'status', 'created_at')
                     ->with('employee:id,name')
                     ->latest();

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

    // Cache counts for 5 minutes to avoid redundant queries
    $totalTasks = \Cache::remember('total_tasks', 300, fn() => Task::count());
    $activeTasks = \Cache::remember('active_tasks', 300, fn() => Task::where('status', 1)->count());
    $inactiveTasks = \Cache::remember('inactive_tasks', 300, fn() => Task::where('status', 0)->count());

    // Employee query with selective columns
    $employeeQuery = Employee::select('id', 'name', 'email', 'phone', 'city', 'created_at')->latest();

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
