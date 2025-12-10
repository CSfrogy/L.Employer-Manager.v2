<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Employee login routes
Route::prefix('employee')->group(function () {
    Route::middleware(['guest:employee'])->group(function () {
        Route::get('/login', [\App\Http\Controllers\Employee\Auth\LoginController::class, 'index'])->name('employee.auth.login');
        Route::post('/login/post', [\App\Http\Controllers\Employee\Auth\LoginController::class, 'login'])->name('employee.login');
        
        // Registration routes
        Route::get('/register', [\App\Http\Controllers\Employee\Auth\LoginController::class, 'showRegisterForm'])->name('employee.register.view');
        Route::post('/register/post', [\App\Http\Controllers\Employee\Auth\LoginController::class, 'register'])->name('employee.register');
    });
});
// Admin login routes
Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('admin.auth.login');
        Route::post('/login/post', [LoginController::class, 'login'])->name('admin.login');
    });
});

// Employee authenticated routes
Route::middleware(['auth:employee'])->group(function () {
    Route::prefix('employee')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('employee.dashboard');
        Route::post('/logout', [\App\Http\Controllers\Employee\Auth\LoginController::class, 'logout'])->name('employee.logout');

        

        // Employee task management routes
        Route::prefix('tasks')->group(function () {
            Route::get('/', [App\Http\Controllers\Employee\TaskController::class, 'index'])->name('employee.tasks.index');
            Route::get('/{id}', [App\Http\Controllers\Employee\TaskController::class, 'show'])->name('employee.tasks.show');
            Route::post('/{id}/status', [App\Http\Controllers\Employee\TaskController::class, 'updateStatus'])->name('employee.tasks.update-status');
            Route::post('/{id}/progress', [App\Http\Controllers\Employee\TaskController::class, 'updateProgress'])->name('employee.tasks.update-progress');
            Route::post('/{id}/extension', [App\Http\Controllers\Employee\TaskController::class, 'requestExtension'])->name('employee.tasks.extension');
        });

        // Employee profile management routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [App\Http\Controllers\Employee\ProfileController::class, 'index'])->name('employee.profile.index');
            Route::post('/update', [App\Http\Controllers\Employee\ProfileController::class, 'update'])->name('employee.profile.update');
            Route::post('/update-password', [App\Http\Controllers\Employee\ProfileController::class, 'updatePassword'])->name('employee.profile.update-password');
            Route::post('/upload-image', [App\Http\Controllers\Employee\ProfileController::class, 'uploadImage'])->name('employee.profile.upload-image');
        });

        // Employee message routes
        Route::prefix('messages')->group(function () {
            Route::get('/', [App\Http\Controllers\Employee\MessageController::class, 'index'])->name('employee.messages.index');
            Route::get('/create', [App\Http\Controllers\Employee\MessageController::class, 'create'])->name('employee.messages.create');
            Route::post('/', [App\Http\Controllers\Employee\MessageController::class, 'store'])->name('employee.messages.store');
            Route::get('/{message}', [App\Http\Controllers\Employee\MessageController::class, 'show'])->name('employee.messages.show');
            Route::delete('/{message}', [App\Http\Controllers\Employee\MessageController::class, 'destroy'])->name('employee.messages.destroy');
            Route::post('/{message}/reply', [App\Http\Controllers\Employee\MessageController::class, 'reply'])->name('employee.messages.reply');
        });
    });
});

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/employee/list', [EmployeeController::class, 'index'])->name('admin.employee.list');
        Route::get('/employee/add', [EmployeeController::class, 'add'])->name('admin.employee.add');
        Route::post('/employee/crate', [EmployeeController::class, 'create'])->name('admin.employee.create');
        Route::post('/employee/delete', [EmployeeController::class, 'delete'])->name('admin.employee.delete');
        Route::post('/employee/delete-from-dashboard', [EmployeeController::class, 'deleteEmployeeFromDashboard'])->name('admin.employee.delete.from.dashboard');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
        Route::post('/employee/update', [EmployeeController::class, 'update'])->name('admin.employee.update');

        Route::get('/tasks/list', [TaskController::class, 'index'])->name('admin.task.list');
        Route::get('/tasks/add', [TaskController::class, 'add'])->name('admin.task.add');
        Route::post('/tasks/create', [TaskController::class, 'create'])->name('admin.task.create');
        Route::post('/tasks/delete', [TaskController::class, 'delete'])->name('admin.task.delete');
        Route::post('/tasks/delete-from-dashboard', [TaskController::class, 'deleteTaskFromDashboard'])->name('admin.task.delete.from.dashboard');
        Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('admin.task.edit');
        Route::post('/tasks/update', [TaskController::class, 'update'])->name('admin.task.update');
        Route::get('/admin/list', [AdminController::class, 'index'])->name('admin.admin.list');
        Route::get('/admin/add', [AdminController::class, 'add'])->name('admin.admin.add');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.admin.store');
        Route::post('/admin/delete', [AdminController::class, 'delete'])->name('admin.admin.delete');
        Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.admin.edit');
        Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.admin.update');

        // Admin mailbox routes
        Route::prefix('mailbox')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\MailboxController::class, 'index'])->name('admin.mailbox.index');
            Route::get('/{message}', [App\Http\Controllers\Admin\MailboxController::class, 'show'])->name('admin.mailbox.show');
            Route::delete('/{message}', [App\Http\Controllers\Admin\MailboxController::class, 'destroy'])->name('admin.mailbox.destroy');
            Route::post('/{message}/reply', [App\Http\Controllers\Admin\MailboxController::class, 'reply'])->name('admin.mailbox.reply');
            Route::post('/{message}/mark-read', [App\Http\Controllers\Admin\MailboxController::class, 'markAsRead'])->name('admin.mailbox.mark-read');
            Route::post('/{message}/mark-unread', [App\Http\Controllers\Admin\MailboxController::class, 'markAsUnread'])->name('admin.mailbox.mark-unread');
        });

        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});