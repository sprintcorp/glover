<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $action;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($action,$subject)
    {
        $this->action = $action;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-email')
            ->subject($this->subject);
    }
}
