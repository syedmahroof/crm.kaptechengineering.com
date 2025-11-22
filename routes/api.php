<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\LeadFollowUpController;
use App\Http\Controllers\Api\LeadNoteController;
use App\Http\Controllers\Api\LeadPriorityController;
use App\Http\Controllers\Api\LeadSourceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DocumentController;

Route::prefix('v1')->group(function () {
    Route::prefix('fcs-calculator')->group(function () {
        Route::post('activities', [ActivityController::class, 'store'])->name('api.activities.store');
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/documents/upload', [DocumentController::class, 'upload']);

// Lead Management Routes
Route::middleware('web')->group(function () {
    Route::get('/lead-sources', [LeadSourceController::class, 'index']);
    Route::get('/lead-priorities', [LeadPriorityController::class, 'index']);
    Route::get('/lead-agents', [\App\Http\Controllers\Api\LeadAgentController::class, 'index']);
    Route::get('/countries', [\App\Http\Controllers\Api\CountryController::class, 'index']);
    Route::get('/states', [\App\Http\Controllers\Api\StateController::class, 'index']);
    Route::get('/districts', [\App\Http\Controllers\Api\DistrictController::class, 'index']);
    
    // Task Management API Routes
    Route::prefix('tasks')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\TaskController::class, 'index']);
        Route::get('/stats', [\App\Http\Controllers\Api\TaskController::class, 'stats']);
        Route::get('/my-tasks', [\App\Http\Controllers\Api\TaskController::class, 'myTasks']);
        Route::get('/users', [\App\Http\Controllers\Api\TaskController::class, 'getUsers']);
        Route::get('/filters', [\App\Http\Controllers\Api\TaskController::class, 'getFilters']);
        Route::post('/', [\App\Http\Controllers\Api\TaskController::class, 'store']);
        Route::get('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'show']);
        Route::put('/{task}/complete', [\App\Http\Controllers\Api\TaskController::class, 'complete']);
        Route::put('/{task}/position', [\App\Http\Controllers\Api\TaskController::class, 'updatePosition']);
        Route::put('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'update']);
        Route::delete('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'destroy']);
    });
});

Route::middleware('web')->group(function () {
    // Customer routes
    Route::apiResource('customers', \App\Http\Controllers\Api\CustomerController::class)->except(['create', 'edit'])->names([
        'index' => 'api.customers.index',
        'store' => 'api.customers.store',
        'show' => 'api.customers.show',
        'update' => 'api.customers.update',
        'destroy' => 'api.customers.destroy'
    ]);
    
    // Additional customer search endpoint
    Route::get('customers/search', [\App\Http\Controllers\Api\CustomerController::class, 'search'])->name('api.customers.search');
    
    // Lead notes endpoints
    Route::prefix('leads/{lead}/notes')->group(function () {
        Route::get('/', [LeadNoteController::class, 'index']);
        Route::post('/', [LeadNoteController::class, 'store']);
        Route::put('/{note}', [LeadNoteController::class, 'update']);
        Route::delete('/{note}', [LeadNoteController::class, 'destroy']);
    });
    
    // Lead follow-ups endpoints
    Route::prefix('leads/{lead}/follow-ups')->group(function () {
        Route::get('/', [LeadFollowUpController::class, 'index']);
        Route::post('/', [LeadFollowUpController::class, 'store']);
        Route::put('/{follow_up}', [LeadFollowUpController::class, 'update']);
        Route::delete('/{follow_up}', [LeadFollowUpController::class, 'destroy']);
    });
    
    // Global follow-ups endpoints (for calendar)
    Route::prefix('follow-ups')->group(function () {
        Route::get('/', [LeadFollowUpController::class, 'indexAll']);
        Route::post('/', [LeadFollowUpController::class, 'storeGlobal']);
    });
    
    // Reminders endpoints
    Route::prefix('reminders')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\ReminderController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\ReminderController::class, 'store']);
        Route::put('/{reminder}', [\App\Http\Controllers\Api\ReminderController::class, 'update']);
        Route::delete('/{reminder}', [\App\Http\Controllers\Api\ReminderController::class, 'destroy']);
    });
    
    // Notification endpoints
    Route::prefix('notifications')->group(function () {
        Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index']);
        Route::post('{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
        Route::post('read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
        Route::delete('{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy']);
    });
});
