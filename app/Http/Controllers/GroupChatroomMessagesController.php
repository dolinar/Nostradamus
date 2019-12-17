<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\GroupChatroomEvent;
use Auth;
use App\User;
Use App\GroupChatroomMessage;

class GroupChatroomMessagesController extends Controller
{
    function fireEvent(Request $request) {
        $message = $request->message;
        $username = Auth::user()->username;
        $profileImg = Auth::user()->profile_image;
        $userId = Auth::user()->id;
        $groupId = $request->groupId;
        $this->saveMessage($username, $message, $groupId);

        event(new GroupChatroomEvent($userId, $message, $username, $profileImg, $groupId));

        return "{}";
    }

    function saveMessage($username, $message, $groupId) {
        $chatroomMessage = new GroupChatroomMessage;
        $chatroomMessage->message = $message;
        $chatroomMessage->id_user = User::where('username', $username)->value('id');
        $chatroomMessage->created_at = date('Y-m-d H:i:s');
        $chatroomMessage->group_id = $groupId;
        $chatroomMessage->save();
    }

    function getChatroomMessages(int $count) {
        $messages = GroupChatroomMessage::with('user')->latest()->take($count)->get();
        $data = ['chatroomMessages' => $messages];
        $html = view('pages.index.chatroom')->with("data", $data)->render();
        return $html;
    }
}
