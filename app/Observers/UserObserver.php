<?php

namespace App\Observers;

use App\Models\MatchComment;
use App\Models\NewsComment;
use App\Models\PlayerComment;
use App\Models\TeamComment;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //update comments pictures and display name when profile is edited
        //news comments
        // NewsComment::where('user_id', $user->id)
        //             ->update(['username' => $user->username, 'display_name'=> $user->display_name]);

        // //team comments
        // TeamComment::where('user_id', $user->id)
        //             ->update(['username' => $user->username, 'display_name'=> $user->display_name]);

        // //player comments
        // PlayerComment::where('user_id', $user->id)
        //             ->update(['username' => $user->username, 'display_name'=> $user->display_name]);

        // //match comments
        // MatchComment::where('user_id', $user->id)
        //             ->update(['username' => $user->username, 'display_name'=> $user->display_name]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
