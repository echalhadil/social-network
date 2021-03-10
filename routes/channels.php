<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('comment-channel', function ($user) {
    return true;
});



Broadcast::channel('notification-channel-.{target_id}', function ($notification, $target_id) {
    return $target_id === Auth::id();
});

Broadcast::channel('friend-request-channel-.{target_id}', function ($friendreqest, $target_id) {
    return $target_id === Auth::id();
});



Broadcast::channel('message-channel-.{target_id}', function ($message,$conversation, $target_id) {
    return $target_id === Auth::id();
});
