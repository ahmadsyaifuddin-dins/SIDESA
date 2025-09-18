<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
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
    public function handle(Login $event): void
    {
        // Ambil user dari event
        $user = $event->user;

        // 1. Matikan logging otomatis HANYA untuk instance user ini, sesaat
        // $user->disableLogging();

        // 2. Lakukan update waktu login terakhir. 
        //    Karena logging dimatikan, aksi ini TIDAK akan membuat log otomatis.
        $user->update(['last_login_at' => now()]);

        // 3. Buat log manual yang kita inginkan
        activity()
           ->performedOn($user)
           ->causedBy($user)
           ->log('User Login nih!');
    }
}

