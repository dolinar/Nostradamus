<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GroupChatroomEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $username;
    public $profileImg;
    public $userId;
    public $groupId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $message, $username, $profileImg, $groupId)
    {
        $this->message = $message;
        $this->username = $username;
        $this->profileImg = $profileImg;
        $this->userId = $userId;
        $this->groupId = $groupId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('group-channel.' . $this->groupId);
    }
}
