<?php

use App\Http\Controllers\ProfileLookupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileLookupController::class, 'index'])->name('home');
Route::post('/lookup', [ProfileLookupController::class, 'lookup'])
    ->middleware('throttle:10,1')
    ->name('profile.lookup');
Route::get('/videos/{videoId}/download', [ProfileLookupController::class, 'download'])
    ->where('videoId', '[A-Za-z0-9_-]+')
    ->middleware('throttle:20,1')
    ->name('video.download');
