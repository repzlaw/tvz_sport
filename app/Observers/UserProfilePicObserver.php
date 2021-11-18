<?php

namespace App\Observers;

use App\Models\NewsComment;
use App\Models\TeamComment;
use App\Models\MatchComment;
use App\Models\PlayerComment;
use App\Models\UserProfilePic;

class UserProfilePicObserver
{
    /**
     * Handle the UserProfilePic "created" event.
     *
     * @param  \App\Models\UserProfilePic  $userProfilePic
     * @return void
     */
    public function created(UserProfilePic $userProfilePic)
    {
        //update comments pictures and display name when profile is edited
        //news comments
        // NewsComment::where('user_id', $userProfilePic->user_id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //team comments
        // TeamComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //player comments
        // PlayerComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //match comments
        // MatchComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);
    }

    /**
     * Handle the UserProfilePic "updated" event.
     *
     * @param  \App\Models\UserProfilePic  $userProfilePic
     * @return void
     */
    public function updated(UserProfilePic $userProfilePic)
    {
        //update comments pictures and display name when profile is edited
        //news comments
        // NewsComment::where('user_id', $userProfilePic->user_id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //team comments
        // TeamComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //player comments
        // PlayerComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);

        // //match comments
        // MatchComment::where('user_id', $userProfilePic->id)
        //             ->update(['profile_pic' => $userProfilePic->file_path]);
    }

    /**
     * Handle the UserProfilePic "deleted" event.
     *
     * @param  \App\Models\UserProfilePic  $userProfilePic
     * @return void
     */
    public function deleted(UserProfilePic $userProfilePic)
    {
        //
    }

    /**
     * Handle the UserProfilePic "restored" event.
     *
     * @param  \App\Models\UserProfilePic  $userProfilePic
     * @return void
     */
    public function restored(UserProfilePic $userProfilePic)
    {
        //
    }

    /**
     * Handle the UserProfilePic "force deleted" event.
     *
     * @param  \App\Models\UserProfilePic  $userProfilePic
     * @return void
     */
    public function forceDeleted(UserProfilePic $userProfilePic)
    {
        //
    }
}
