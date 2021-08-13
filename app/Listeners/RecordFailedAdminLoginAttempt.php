<?php

namespace App\Listeners;

use App\Mail\AdminFailedLogin;
use App\Mail\EditorFailedLogin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Mail;
use App\Models\AdminFailedLoginAttempt;
use App\Models\EditorFailedLoginAttempt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        if ($event->guard ==='admin') {

            Mail::to('work@tvz.com', 'TVZ')->queue(new AdminFailedLogin($event));

            AdminFailedLoginAttempt::record(
                $event->user,
                $event->credentials['email'],
                request()->ip(),
                getBrowser()
            );
        } else if ($event->guard ==='editor') {

            Mail::to('work@tvz.com', 'TVZ')->queue(new EditorFailedLogin($event));

            EditorFailedLoginAttempt::record(
                $event->user,
                $event->credentials['email'],
                request()->ip(),
                getBrowser()
            );
        }
        
        // dd($event->guard);
        // Mail::to('work@tvz.com', 'TVZ')->queue(new AdminFailedLogin($event));

        

    }
}
