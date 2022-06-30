<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $approval;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval,$subject)
    {
        $this->approval = $approval;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user-email')->subject($this->subject);
    }
}
