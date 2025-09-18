<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
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
    public function handle(Logout $event): void
    {
        // Pastikan ada user yang logout untuk dicatat
        if ($event->user) {
            activity()
               ->performedOn($event->user)
               ->causedBy($event->user)
               ->log('User Logout nih!');
        }
    }
}
