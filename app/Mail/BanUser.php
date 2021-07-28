<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BanUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Account Suspension";
    public $error;
    public $user;
    public $admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($error,$user,$admin)
    {
        $this->error = $error;
        $this->user = $user;
        $this->admin = $admin;
        // dd($this->user);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = $this->admin;
        // dd($admin);
        return $this->from($admin->email, $admin->username)->markdown('emails.banUser');
    }
}
