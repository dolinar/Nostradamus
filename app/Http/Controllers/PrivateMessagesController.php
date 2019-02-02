<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
use App\PrivateMessage;
use Auth;

class PrivateMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newMessages = $this->getReceivedMessages(Auth::id(), 0);
        $readMessages = $this->getReceivedMessages(Auth::id(), 1);

        $sentMessages = $this->getSentMessages(Auth::id());
        
        $data = [
            'newMessages' => $newMessages,
            'readMessages' => $readMessages,
            'sentMessages' => $sentMessages
        ];

        return view('privatemessages.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $user = User::find($request->id)->toArray();
        return view('privatemessages.create')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'subject' => 'required'
        ]);

        $privateMessage = new PrivateMessage;
        $privateMessage->id_sender = Auth::id();
        $privateMessage->id_receiver = $request->id_receiver;
        $privateMessage->subject = $request->subject;
        $privateMessage->message = $request->body;

        $privateMessage->save();

        return redirect('/user_profile/' . $request->id_receiver)->with('success', 'Sporočilo uspešno poslano.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $privateMessage = PrivateMessage::find($id);
        $sender = User::find($privateMessage->id_sender);

        if (Auth::id() !== $privateMessage->id_receiver && Auth::id() !== $privateMessage->id_sender) {
            return redirect('/');
        }

        $privateMessage->update(['opened' => 1]);
        $privateMessage->save();

        $data = [
            'privateMessage' => $privateMessage,
            'sender' => $sender
        ];
        return view('privatemessages.show')->with('data', $data);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $privateMessage = PrivateMessage::find($id);
        $privateMessage->delete();

        return redirect('/private_message')->with('success', 'Sporočilo uspešno izbrisano');
    }


    private function getSentMessages($userId) {
        return User::find($userId)
                        ->sentMessages()
                        ->select('private_messages.id', 'users.username', 'private_messages.message', 'private_messages.subject', 'private_messages.created_at')
                        ->join('users', 'users.id', '=', 'private_messages.id_receiver')
                        ->get();
    }

    private function getReceivedMessages($idUser, $opened) {
        return User::find($idUser)
                ->receivedMessages()
                ->select('private_messages.id', 'users.username', 'private_messages.message', 'private_messages.subject', 'private_messages.created_at')
                ->join('users', 'users.id', '=', 'private_messages.id_sender')
                ->where('private_messages.opened', '=', $opened)
                ->get();
    }
}
