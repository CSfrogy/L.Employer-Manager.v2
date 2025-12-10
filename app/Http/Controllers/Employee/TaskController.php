<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $query = $employee->tasks()->select('id', 'emp_id', 'title', 'content', 'date', 'status', 'progress', 'created_at')->with('employee:id,name');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $tasks = $query->latest()->paginate(10);

        return view('employee.tasks.index', [
            'tasks' => $tasks,
            'employee' => $employee,
            'user' => $employee,
            'userRole' => 'employee'
        ]);
    }

    public function show($id)
    {
        $employee = Auth::guard('employee')->user();
        $task = $employee->tasks()->findOrFail($id);

        return view('employee.tasks.show', [
            'task' => $task,
            'employee' => $employee,
            'user' => $employee,
            'userRole' => 'employee'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $employee = Auth::guard('employee')->user();
        $task = $employee->tasks()->findOrFail($id);

        $validation = Validator::make($request->all(), [
            'status' => 'required|in:0,1,2,3',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $task->status = $request->status;
        $task->notes = $request->notes;
        $task->save();

        $statusText = match($request->status) {
            0 => 'inactive',
            1 => 'active',
            2 => 'completed',
            3 => 'on-hold',
            default => 'unknown'
        };

        return redirect()->route('employee.tasks.index')
            ->with('success', "Task status updated to '{$statusText}' successfully.");
    }

    public function updateProgress(Request $request, $id)
    {
        $employee = Auth::guard('employee')->user();
        $task = $employee->tasks()->findOrFail($id);

        $validation = Validator::make($request->all(), [
            'progress' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $task->progress = $request->progress;
        $task->notes = $request->notes;

        if ($request->progress == 100) {
            $task->status = 2;
        } elseif ($request->progress > 0) {
            $task->status = 1;
        }

        $task->save();

        return redirect()->route('employee.tasks.show', $id)
            ->with('success', 'Task progress updated successfully.');
    }

    public function requestExtension(Request $request, $id)
    {
        $employee = Auth::guard('employee')->user();
        $task = $employee->tasks()->findOrFail($id);

        $validation = Validator::make($request->all(), [
            'reason' => 'required|string|max:500',
            'new_date' => 'required|date|after:today'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

    
        $task->extension_request = json_encode([
            'reason' => $request->reason,
            'new_date' => $request->new_date,
            'requested_at' => now(),
            'status' => 'pending'
        ]);
        $task->save();

        return redirect()->route('employee.tasks.show', $id)
            ->with('success', 'Extension request submitted successfully. It will be reviewed by your manager.');
    }

    public function getTaskStats()
    {
        $employee = Auth::guard('employee')->user();
        
        // Cache stats for 10 minutes per employee
        $cacheKey = "task_stats_{$employee->id}";
        
        return \Cache::remember($cacheKey, 600, function() use ($employee) {
            $tasks = $employee->tasks();

            $stats = [
                'total_tasks' => $tasks->count(),
                'active_tasks' => $tasks->where('status', 1)->count(),
                'completed_tasks' => $tasks->where('status', 2)->count(),
                'overdue_tasks' => $tasks->where('date', '<', now())->whereNotIn('status', [2])->count(),
                'completion_rate' => $tasks->count() > 0 ?
                    round(($tasks->where('status', 2)->count() / $tasks->count()) * 100, 2) : 0
            ];

            return $stats;
        });
    }
}
