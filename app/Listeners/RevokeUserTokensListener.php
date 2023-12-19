<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Sanctum\PersonalAccessToken;

class RevokeUserTokensListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // Revoke all personal access tokens for the user
        PersonalAccessToken::where('tokenable_id', $event->userId)
            ->where('tokenable_type', 'App\Models\User')
            ->delete();
    }
}
