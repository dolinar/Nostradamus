<?php

namespace App\Listeners;

use App\Events\ChatroomEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        // save to DB.
        return $event;
    }
}
