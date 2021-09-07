<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserProfilePic;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\UserProfilePicObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \Illuminate\Auth\Events\Failed::class => [
            \App\Listeners\RecordFailedAdminLoginAttempt::class,
        ],
        // \Illuminate\Auth\Events\Failed::class => [
        //     \App\Listeners\RecordFailedEditorLoginAttempt::class,
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        UserProfilePic::observe(UserProfilePicObserver::class);
    }
}
