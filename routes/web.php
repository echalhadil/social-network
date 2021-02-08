<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');



Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia\Inertia::render('Main');
})->name('main');
Route::middleware(['auth:sanctum', 'verified'])->get('/modal', function () {
    return Inertia\Inertia::render('Modal');
})->name('modal');



Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);
Route::resource('reacts', ReactController::class);
Route::resource('profiles', ProfileController::class);
Route::resource('notifications', NotificationController::class);



// update profile picture 
Route::post('profiles/{id}/updateprofilepicture',[ProfileController::class,'updateProfilePicture']);
Route::post('profiles/{id}/deleteprofilepicture',[ProfileController::class,'deleteProfilePicture']);