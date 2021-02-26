<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactController;
use App\Http\Controllers\SearchController;
use App\Models\FriendRequest;
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
Route::resource('friends', FriendController::class);
Route::resource('friendrequests', FriendRequestController::class);
Route::resource('results', SearchController::class);









// update profile picture 
Route::post('profiles/{id}/updateprofilepicture',[ProfileController::class,'updateProfilePicture']);
Route::post('profiles/{id}/deleteprofilepicture',[ProfileController::class,'deleteProfilePicture']);

Route::get('profiles/{id}/posts',[ProfileController::class,'posts']);
Route::get('profiles/{id}/friends',[ProfileController::class,'friends']);

Route::get('profiles/{id}/arefriends',[ProfileController::class,'areFriends']);
Route::get('profiles/{id}/yourecivedrequest',[ProfileController::class,'youRecivedRequest']);
Route::get('profiles/{id}/yousentrequest',[ProfileController::class,'youSentRequest']);
Route::get('profiles/{id}/deleterequest',[ProfileController::class,'deleteRequest']);





//update notification status 
Route::get('seenotifications',[NotificationController::class,'seeNotifications']);


//messenger 
Route::middleware(['auth:sanctum', 'verified'])->get('/messenger', function () {
    return Inertia\Inertia::render('Messenger/Main');
})->name('dashboard');