<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\NoteCommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SectionController;
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
Route::group(['middleware' => 'auth:api'], function () {

    Route::controller(KanbanController::class)->group(function () {
        Route::get('/kanban/export', 'export')->name('kanbans.export');
        Route::get('/kanban', 'index')->name('kanbans.index');
    });


    Route::apiResource('sections', SectionController::class)
        ->except('index');

    Route::controller(NoteController::class)->group(function () {
        Route::post('/sections/{section}/notes/', 'store')->name('notes.store');
        Route::put('/sections/{section}/notes/{note}/move', 'move')->name('notes.move');

    });

    Route::apiResource('notes', NoteController::class)
        ->except(['index', 'store']);

    Route::post('/notes/{note}/comments/', NoteCommentController::class)
        ->name('notes.comments.store');

    Route::apiResource('comments', CommentController::class)
        ->except('index', 'store');

});

require __DIR__ . '/auth.php';
