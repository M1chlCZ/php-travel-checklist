<?php

use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\TripController;
use App\Http\Middleware\DemoToken;
use Illuminate\Support\Facades\Route;

Route::middleware(DemoToken::class)->scopeBindings()->group(function (): void {
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips/{trip}', [TripController::class, 'show']);
    Route::post('/trips/{trip}/items', [ChecklistItemController::class, 'store']);
    Route::patch('/trips/{trip}/items/{item}', [ChecklistItemController::class, 'update']);
});
