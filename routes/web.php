<?php

use App\Http\Controllers\WebUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/forgot', [WebUsersController::class, 'forgot']);
Route::get('/reset/{email}/{token}', [WebUsersController::class, 'reset'])->name('reset');
Route::post('/register', [WebUsersController::class, 'saveUser'])->name('auth.register');
Route::post('/loginauth', [WebUsersController::class, 'loginUser'])->name('auth.login');
Route::get('/signup', [WebUsersController::class, 'signup']);
Route::post('/forgot', [WebUsersController::class, 'resetEmail'])->name('auth.reset');



Route::middleware(['is_loggedin'])->group(function () {
    Route::get('/', [WebUsersController::class, 'index']);
    Route::get('/dashboard', [WebUsersController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [WebUsersController::class, 'logout'])->name('logout');
    Route::post('/profile-image', [WebUsersController::class, 'imageUpdate'])->name('image.update');
    Route::post('/update-info', [WebUsersController::class, 'updateInfo'])->name('auth.update');

});