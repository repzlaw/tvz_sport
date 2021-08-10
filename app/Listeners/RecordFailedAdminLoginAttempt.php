<?php

namespace App\Listeners;

use App\Models\AdminFailedLoginAttempt;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordFailedAdminLoginAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        AdminFailedLoginAttempt::record(
            $event->user,
            $event->credentials['email'],
            request()->ip(),
            getBrowser()
        );
    }
}
