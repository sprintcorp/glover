<?php

namespace App\Listeners;

use App\Events\UserActionEvent;
use App\Mail\UserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class UserActionListener implements ShouldQueue
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
     * @param UserActionEvent $userActionEvent
     * @return void
     */
    public function handle(UserActionEvent $userActionEvent)
    {
        try {
            Mail::to($userActionEvent->email)->send(new UserMail(
                $userActionEvent->approval->action,
                $userActionEvent->subject));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
