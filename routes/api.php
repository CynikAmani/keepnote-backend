<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoGroupController;
use App\Http\Controllers\TodoItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum', 'throttle:60,1')->group(function () {

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
        Route::get('/{id}', [RoleController::class, 'show'])->middleware('permission:view-roles');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:create-role');
        Route::put('/{role}', [RoleController::class, 'update'])->middleware('permission:update-role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete-role');
    });

    // --- Permissions ---
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->middleware('permission:view-permissions');
        Route::get('/{permission}', [PermissionController::class, 'show'])->middleware('permission:view-permissions');
        Route::post('/', [PermissionController::class, 'store'])->middleware('permission:create-permission');
        Route::put('/{permission}', [PermissionController::class, 'update'])->middleware('permission:update-permission');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:delete-permission');
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
        Route::get('/{note}', [NoteController::class, 'show'])->middleware('permission:view-notes');
        Route::post('/', [NoteController::class, 'store'])->middleware('permission:create-note');
        Route::put('/{note}', [NoteController::class, 'update'])->middleware('permission:update-note');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->middleware('permission:delete-note');
    });

    // --- TodoGroups ---
    Route::prefix('todolist-groups')->group(function () {
        Route::get('/', [TodoGroupController::class, 'index'])->middleware('permission:view-todo-groups');
        Route::get('/{group}', [TodoGroupController::class, 'show'])->middleware('permission:view-todo-groups');
        Route::post('/', [TodoGroupController::class, 'store'])->middleware('permission:create-todo-group');
        Route::put('/{group}', [TodoGroupController::class, 'update'])->middleware('permission:update-todo-group');
        Route::delete('/{group}', [TodoGroupController::class, 'destroy'])->middleware('permission:delete-todo-group');
    });

    // --- TodoItems ---
    Route::prefix('todolist-items')->group(function () {
        Route::get('/', [TodoItemController::class, 'index'])->middleware('permission:view-todo-items');
        Route::get('/{item}', [TodoItemController::class, 'show'])->middleware('permission:view-todo-items');
        Route::post('/', [TodoItemController::class, 'store'])->middleware('permission:create-todo-item');
        Route::put('/{item}', [TodoItemController::class, 'update'])->middleware('permission:update-todo-item');
        Route::delete('/{item}', [TodoItemController::class, 'destroy'])->middleware('permission:delete-todo-item');
    });

});