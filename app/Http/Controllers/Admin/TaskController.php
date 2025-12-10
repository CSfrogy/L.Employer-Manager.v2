<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('employee')->latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function add()
    {
        $employees = Employee::latest()->get();
        return view('admin.tasks.create', compact('employees'));
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'employee' => 'required|exists:employees,id',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'date' => 'required|date',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            $task = new Task();
            $task->title = $request->input('title');
            $task->content = $request->input('content');
            $task->emp_id = $request->input('employee');
            $task->date = $request->input('date');
            $task->status = $request->input('status');
            $result = $task->save();

            if ($result) {
                return redirect()->route('admin.task.list')->with('success', 'Task created successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to create task')->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the task')->withInput();
        }
    }

    public function delete(Request $request)
    {
        $result = Task::findOrFail($request->id)->delete();

        if ($result) {
            return redirect()->route('admin.task.list')->with('success', 'Task deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Task not deleted successfully');
        }
    }
    public function deleteTaskFromDashboard(Request $request)
    {
        try {
            $task = Task::findOrFail($request->id);
            $taskTitle = $task->title;
            $task->delete();
            return redirect()->route('admin.dashboard')
                ->with('task_success', "Task '{$taskTitle}' has been successfully deleted.");
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('task_error', 'Failed to delete task. Please try again.');
        }
    }


    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $employees = Employee::latest()->get();
        return view('admin.tasks.update', compact(['task', 'employees']));
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'employee' => 'required|exists:employees,id',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'date' => 'required|date',
        ]);

        if ($validation->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation->errors()
                ]);
            }
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            $task = Task::findOrFail($request->input('id'));
            $task->title = $request->input('title');
            $task->content = $request->input('content');
            $task->emp_id = $request->input('employee');
            $task->date = $request->input('date');
            $task->status = $request->input('status');
            $result = $task->save();

            if ($result) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Task updated successfully!'
                    ]);
                }
                return redirect()->route('admin.task.list')->with('success', 'Task updated successfully');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to update task'
                    ]);
                }
                return redirect()->back()->with('error', 'Failed to update task')->withInput();
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the task'
                ]);
            }
            return redirect()->back()->with('error', 'An error occurred while updating the task')->withInput();
        }
    }
}
