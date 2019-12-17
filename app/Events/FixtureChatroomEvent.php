<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\User;
class FixtureChatroomEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $message;
    public $fixtureId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $message, $fixtureId)
    {
        $this->user = $user;
        $this->message = $message;
        $this->fixtureId = $fixtureId;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PresenceChannel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('fixture.' . $this->fixtureId);
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'message' => $this->message,
            'fixtureId' => $this->fixtureId
        ];
    }
}
