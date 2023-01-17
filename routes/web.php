<?php

use Illuminate\Support\Facades\Route;

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
    'last_user_activity'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum','admin','last_user_activity'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/',\App\Http\Livewire\Admin\Dashboard\DashboardIndex::class)->name('index');
    Route::get('/users',\App\Http\Livewire\Admin\Users\UsersIndex::class)->name('users.index');
    Route::get('/settings',\App\Http\Livewire\Admin\Settings\SettingsIndex::class)->name('settings.index');
});
