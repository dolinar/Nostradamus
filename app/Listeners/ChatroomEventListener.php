<?php

namespace App\Listeners;

use App\Events\ChatroomEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ChatroomMessage;
use Auth;

class ChatroomEventListener
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
     * @param  ChatroomEvent  $event
     * @return void
     */
    public function handle(ChatroomEvent $event)
    {
        // TODO: groups.
        return $event;
    }
}
