<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminFailedLogin extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Failed Login";
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('work@tvz.com', 'TVZ')->markdown('emails.failedLogins.adminFailedLogin');
    }
}
