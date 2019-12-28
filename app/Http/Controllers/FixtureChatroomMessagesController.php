<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\FixtureChatroomEvent;
use Auth;
use App\User;
Use App\FixtureChatroomMessage;

class FixtureChatroomMessagesController extends Controller
{
    function fireEvent(Request $request) {
        $message = $request->message;
        $username = Auth::user()->username;
        $fixtureId = $request->fixtureId;
        $this->saveMessage($username, $message, $fixtureId);
        event(new FixtureChatroomEvent(Auth::user(), $message, $fixtureId));
        //broadcast(new FixtureChatroomEvent(Auth::user(), $message, $fixtureId))->toOthers();
        return "{}";
    }

    function saveMessage($username, $message, $fixtureId) {
        $chatroomMessage = new FixtureChatroomMessage;
        $chatroomMessage->message = $message;
        $chatroomMessage->id_user = User::where('username', $username)->value('id');
        $chatroomMessage->created_at = date('Y-m-d H:i:s');
        $chatroomMessage->id_fixture = $fixtureId;
        $chatroomMessage->save();
    }

    function getChatroomMessages(int $count) {
        $messages = FixtureChatroomMessage::with('user')->latest()->take($count)->get();
        $data = ['chatroomMessages' => $messages];
        $html = view('pages.livematches.chatroom')->with("data", $data)->render();
        return $html;
    }
}
