<?php

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

// Canal privé pour les ventes
// Accessible uniquement par les utilisateurs authentifiés avec rôle gerant ou super-admin
Broadcast::channel('sales', function ($user) {
    return $user->hasRole('gerant') || $user->hasRole('super-admin');
});

// Canal privé pour les activités
// Accessible uniquement par les super-admins
Broadcast::channel('activity', function ($user) {
    return $user->hasRole('super-admin');
});
