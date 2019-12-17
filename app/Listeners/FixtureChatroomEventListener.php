<?php

namespace App\Listeners;

use App\Events\FixtureChatroomEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\FixtureChatroomMessage;
use Auth;

class FixtureChatroomEventListener
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
    public function handle(FixtureChatroomEvent $event)
    {
        return $event;
    }
}
