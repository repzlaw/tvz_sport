<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnbanUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Account Unsuspension";
    public $message;
    public $user;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message,$user,$admin)
    {
        $this->message = $message;
        $this->user = $user;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = $this->admin;
        return $this->from($admin->email, $admin->username)->markdown('emails.UnbanUser');
    }
}
