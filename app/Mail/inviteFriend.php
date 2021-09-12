<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class inviteFriend extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "TVZ_SPORT Invite";
    public $display_name;
    public $user_email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($display_name,$user_email)
    {
        $this->user_email = $user_email;
        $this->display_name = $display_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $display_name = $this->display_name;
        return $this->from($this->user_email, $this->display_name)->markdown('emails.user.invite-friend');
    }
}
