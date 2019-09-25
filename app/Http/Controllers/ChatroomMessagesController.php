<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatroomEvent;
use Auth;
use App\User;
Use App\ChatroomMessage;

class ChatroomMessagesController extends Controller
{
    //
    function fireEvent(Request $request) {
        $message = $request->message;
        $username = Auth::user()->username;

        $this->saveMessage($username, $message);

        event(new ChatroomEvent($message, $username));
    }

    function saveMessage($username, $message) {
        $chatroomMessage = new ChatroomMessage;
        $chatroomMessage->message = $message;
        $chatroomMessage->id_user = User::where('username', $username)->value('id');
        $chatroomMessage->created_at = date('Y-m-d H:i:s');

        $chatroomMessage->save();
    }
}
