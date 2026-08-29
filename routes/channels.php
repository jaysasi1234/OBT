<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatGroup;

Broadcast::channel(
    'admin.cadet-locations',
    function ($user) {

        return in_array(
            strtolower((string) $user->role),
            [
                'admin',
                'super_admin',
                'dean',
            ],
            true
        );
    }
);

Broadcast::channel(
    'chat-group.{groupId}',
    function ($user, $groupId) {

        $group = ChatGroup::find($groupId);

        if (!$group) {
            return false;
        }

        /*
         * Admin can access batch groups.
         */

        if ($user->role === 'admin') {
            return true;
        }

        /*
         * Cadet can only access groups
         * they belong to.
         */

        return $group->members()
            ->where('users.id', $user->id)
            ->exists();
    }
);

/*
|--------------------------------------------------------------------------
| Chat Channel
|--------------------------------------------------------------------------
*/

Broadcast::channel('chat.user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});


/*
|--------------------------------------------------------------------------
| Notification Channel
|--------------------------------------------------------------------------
|
| Laravel broadcasts notifications on:
| App.Models.User.{id}
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});