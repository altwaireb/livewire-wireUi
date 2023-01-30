<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'last_user_activity',
    'check_banned'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::middleware('admin')->prefix('admin')->as('admin.')->group(function () {

        Route::get('/', \App\Http\Livewire\Admin\Dashboard\DashboardIndex::class)
            ->name('index');

        Route::get('/users', \App\Http\Livewire\Admin\Users\UsersIndex::class)
            ->name('users.index')
            ->can('viewAny', \App\Models\User::class);

        Route::get('/settings', \App\Http\Livewire\Admin\Settings\SettingsIndex::class)
            ->name('settings.index')
            ->can('viewAny', \App\Models\Setting::class);

        Route::get('/roles', \App\Http\Livewire\Admin\Roles\RolesIndex::class)
            ->name('roles.index')
            ->can('viewAny', \App\Models\Role::class);

        Route::get('/permissions', \App\Http\Livewire\Admin\Permissions\PermissionsIndex::class)
            ->name('permissions.index')
            ->can('viewAny', \App\Models\Permission::class);

    });
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', [\Laravel\Fortify\Http\Controllers\EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [\Laravel\Fortify\Http\Controllers\VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [\Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});