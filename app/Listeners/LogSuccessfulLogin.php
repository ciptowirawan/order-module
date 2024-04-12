<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginLog;

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
        if (auth()->user()->hasRole(['user'])) {
            LoginLog::create([
                'user_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'timestamp' => now()
            ]);
        }
    }
}
