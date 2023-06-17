<?php

use App\Http\Controllers\API\TimelineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Timeline
Route::controller(TimelineController::class)->group(function () {
    // Get a list of timelines
    Route::get('/timeline', 'index')->name('timeline.index');
    // Get details of the timeline
    Route::get('/timeline/{timeline_id}', 'show')->name('timeline.show');
    // Create a new record of the timeline
    Route::post('/timeline', 'store')->name('timeline.store');
    // Update the record of the timeline
    Route::put('/timeline/{timeline_id}', 'update')->name('timeline.update');
    // Delete the record of the timeline
    Route::delete('/timeline/{timeline_id}', 'destroy')->name('timeline.destroy');
});
