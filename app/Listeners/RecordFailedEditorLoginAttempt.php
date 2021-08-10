<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\EditorFailedLoginAttempt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordFailedEditorLoginAttempt
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
        EditorFailedLoginAttempt::record(
            $event->user,
            $event->credentials['email'],
            request()->ip(),
            getBrowser()
        );
    }
}
