<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoGroupController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Public Auth Routes (Rate Limited) ---
Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signup', [AuthController::class, 'signup']);
});

// --- Protected Routes (Authenticated + Rate Limited) ---
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // --- Dashboard (we break REST standard for efficiency) ---
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // --- Users ---
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:view-users');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('permission:view-users');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:create-user');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:update-user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:delete-user');
    });

    // --- Roles ---
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware('permission:view-roles');
        Route::get('/{role}', [RoleController::class, 'show'])->middleware('permission:view-roles');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:create-role');
        Route::put('/{role}', [RoleController::class, 'update'])->middleware('permission:update-role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete-role');

        // Role Permissions
        Route::get('/{role}/permissions', [RolePermissionController::class, 'index'])->middleware('permission:view-role-permissions');
        Route::put('/{role}/permissions', [RolePermissionController::class, 'sync'])->middleware('permission:update-role-permissions');
        Route::delete('/{role}/permissions/{permission}', [RolePermissionController::class, 'revoke'])->middleware('permission:update-role-permissions');
    });

   // --- Permissions ---
   Route::prefix('permissions')->group(function () {
       Route::get('/', [PermissionController::class, 'index'])->middleware('permission:view-roles'); 
       Route::post('/', [PermissionController::class, 'store'])->middleware('permission:create-role');
       Route::put('/{permission}', [PermissionController::class, 'update'])->middleware('permission:update-role');
       Route::delete('/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:delete-role');
   });

    // --- Labels ---
    Route::prefix('labels')->group(function () {
        Route::get('/', [LabelController::class, 'index'])->middleware('permission:view-labels');
        Route::get('/{id}', [LabelController::class, 'show'])->middleware('permission:view-labels');
        Route::post('/', [LabelController::class, 'store'])->middleware('permission:create-label');
        Route::put('/{label}', [LabelController::class, 'update'])->middleware('permission:update-label');
        Route::delete('/{label}', [LabelController::class, 'destroy'])->middleware('permission:delete-label');
    });

    // --- Notes ---
    Route::prefix('notes')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->middleware('permission:view-notes');
        Route::get('/archived', [NoteController::class, 'archived'])->middleware('permission:view-notes');
        Route::get('/{note}', [NoteController::class, 'show'])->middleware('permission:view-notes');
        Route::post('/', [NoteController::class, 'store'])->middleware('permission:create-note');
        Route::put('/{note}', [NoteController::class, 'update'])->middleware('permission:update-note');
        Route::patch('/{note}/pin', [NoteController::class, 'togglePin'])->middleware('permission:update-note');
        Route::patch('/{note}/archive', [NoteController::class, 'archive'])->middleware('permission:update-note');
        Route::patch('/{note}/unarchive', [NoteController::class, 'unarchive'])->middleware('permission:update-note');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->middleware('permission:delete-note');
    });

    // --- TodoGroups ---
    Route::prefix('todo-groups')->group(function () {
        Route::get('/', [TodoGroupController::class, 'index'])->middleware('permission:view-todo-groups');
        Route::get('/{todoGroup}', [TodoGroupController::class, 'show'])->middleware('permission:view-todo-groups');
        Route::post('/', [TodoGroupController::class, 'store'])->middleware('permission:create-todo-group');
        Route::put('/{todoGroup}', [TodoGroupController::class, 'update'])->middleware('permission:update-todo-group');
        Route::delete('/{todoGroup}', [TodoGroupController::class, 'destroy'])->middleware('permission:delete-todo-group');
        Route::patch('/{todoGroup}/archive', [TodoGroupController::class, 'archive'])->middleware('permission:update-todo-group');
        Route::patch('/{todoGroup}/toggle-pin', [TodoGroupController::class, 'togglePin'])->middleware('permission:update-todo-group');
        
        // Batch Items
        Route::post('/{todoGroup}/items/batch', [TodoItemController::class, 'batchStore'])->middleware('permission:create-todo-item');
        Route::patch('/{todoGroup}/items/batch', [TodoItemController::class, 'batchUpdate'])->middleware('permission:update-todo-item');
    });

    // --- TodoItems ---
    Route::prefix('todo-items')->group(function () {
        Route::post('/', [TodoItemController::class, 'store'])->middleware('permission:create-todo-item');
        Route::patch('/{todoItem}', [TodoItemController::class, 'update'])->middleware('permission:update-todo-item');
        Route::delete('/{todoItem}', [TodoItemController::class, 'destroy'])->middleware('permission:delete-todo-item');
        Route::patch('/{todoItem}/toggle', [TodoItemController::class, 'toggleCompletion'])->middleware('permission:update-todo-item');
        Route::patch('/{todoItem}/position', [TodoItemController::class, 'updatePosition'])->middleware('permission:update-todo-item');
    });

});