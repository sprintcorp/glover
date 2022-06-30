<?php

namespace App\Events;

use App\Models\Approval;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $approval;
    public $email;
    public $subject;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Approval $approval, $email, $subject)
    {
        $this->email = $email;
        $this->approval = $approval;
        $this->subject = $subject;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
