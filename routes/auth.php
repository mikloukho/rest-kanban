<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegisterController::class)
                ->middleware('guest')
                ->name('register');

Route::post('/login', LoginController::class)
                ->middleware('guest')
                ->name('login');

Route::post('/forgot-password', ForgotPasswordController::class)
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', ResetPasswordController::class)
                ->middleware('guest')
                ->name('password.store');

Route::post('/logout', LogoutController::class)
    ->middleware('auth:api')
    ->name('logout');
