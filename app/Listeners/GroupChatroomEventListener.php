<?php

namespace App\Listeners;

use App\Events\GroupChatroomEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\GroupChatroomMessage;
use Auth;
class GroupChatroomEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(GroupChatroomEvent $event)
    {
        return $event;
    }
}
