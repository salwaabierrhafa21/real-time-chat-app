<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/chat', [ChatController::class, 'index']);

    Route::get('/chat/{user}', [ChatController::class, 'show'])
        ->name('chat.show');
    
    Route::post('/chat/{user}/send', [ChatController::class, 'sendMessage'])
    ->name('chat.send');
});