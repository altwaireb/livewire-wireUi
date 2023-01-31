<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->namespace('V1')->group(function () {

    // Prefix Auth Route
    Route::prefix('auth')->as('auth.')->group(function () {
        // Guest
        Route::middleware('guest')->group(function () {
            // Register
            Route::post('register', [AuthController::class, 'register'])->name('register');
            // Login
            Route::post('login', [AuthController::class, 'login'])->name('login');
            // Send Password Reset Link Email
            Route::post('/password/email', [AuthController::class, 'sendPasswordResetLinkEmail'])
                ->middleware('throttle:5,1')->name('password.email');

        });

        Route::middleware(['auth:sanctum', 'last_user_activity', 'check_banned'])->group(function () {
            // Logout
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            // User Info
            Route::get('/user', [AuthController::class, 'getUser'])->name('user');
            // Reset Password
            Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

        });

    });

    // All Route for User
    Route::group(['middleware' => ['auth:sanctum', 'last_user_activity', 'check_banned']], function () {

    });

});
