<?php
use Illuminate\Support\Facades\DB;
use App\User;

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

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('group-channel.{groupId}', function ($user, $groupId) {
//     return (int) $user->id === (int) $groupId;
// });


Broadcast::channel('fixture.{fixtureId}', function ($user, $fixtureId) {
    return true;
});
