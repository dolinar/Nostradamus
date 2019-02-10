<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;
use App\Prediction;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use App\PrivateMessage;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();

        $predictionsData = $this->getPredictionsData();
        $overallPrediction = $this->getOverallPrediction();
        $invitations = $this->getInvitations();

        $receivedMessages = $this->getReceivedMessages($userId);
        $user = $this->getUser($userId);
        $userData = $this->getUserData($userId);
        
        $data = [
            'overallPrediction' => $overallPrediction,
            'invitations' => $invitations,
            'difference' => $predictionsData['numberOfActiveFixtures'] - $predictionsData['numberOfPredictions'],
            'receivedMessages' => $receivedMessages,
            'user' => $user,
            'userData' => $userData,
        ];

        return view('dashboard.dashboard')->with('data', $data);
    }

    public function edit($id) {
        $userId = Auth::id();
        if ($id != $userId) {
            return redirect('/dashboard');
        }

        $data = [
            'id' => $userId
        ];
        return view('dashboard.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'profile_image' => 'image|nullable|max:1999'
        ]);

        $user = User::find($id);
        $filenameToStore = 'user_default.png';

        if ($request->hasFile('profile_image')) {
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            
            $ext = $request->file('profile_image')->getClientOriginalExtension();

            $filenameToStore = $filename . '_' . time() . '.' . $ext;

            $path = $request->file('profile_image')->storeAs('public/profile_images', $filenameToStore);
        } 

        $user->profile_image = $filenameToStore;
        $user->save();

        return redirect('/dashboard')->with('success', 'Profil uspešno posodobljen');

    }

    private function getUser($id) {
        return User::find($id)
                    ->join('logins', function($join) use($id) {
                        $join->on('users.id', '=', 'logins.id_user');
                        $join->where('logins.id_user', '=', $id);
                    })
                    ->orderBy('logins.id', 'DESC')
                    ->take(1)
                    ->get();
    }

    private function getUserData($id) {
        return $userData = User::find($id)
                    ->join('user_data_flow', function($join) use($id) {
                        $join->on('users.id', '=', 'user_data_flow.id_user');
                        $join->where('user_data_flow.id_user', '=', $id);
                    })
                    ->orderBy('user_data_flow.id', 'DESC')
                    ->take(1)
                    ->get();
    }


    public function getInvitations() {
        $invitations = array();

        if (auth()->user()) {
            $invitations = DB::table('group_invitations')
                ->select('group_invitations.id', 'u1.username as user', 'u2.username as user_invitator', 'groups.name')
                ->join('users as u1',  'group_invitations.id_user', '=', 'u1.id')
                ->join('users as u2',  'group_invitations.id_user_invitator', '=', 'u2.id')
                ->join('groups', 'group_invitations.id_group', '=', 'groups.id')
                ->where('group_invitations.id_user', '=', auth()->user()->id)
                ->where('group_invitations.status', '=', '0')
                ->get();
        }

        return $invitations;
    }


    
    private function getPredictionsData() {
        // Check if count of all current fixtures is greater than number of user's number of ACTIVE predictions
        $numberOfActiveFixtures = 0;
        $numberOfPredictions = 0;
        if (auth()->user()){
            $numberOfActiveFixtures = count(Fixture::where('status', 'NS')->get());
            $numberOfPredictions = count(DB::select('SELECT * FROM predictions p LEFT JOIN fixtures f ON p.id_fixture = f.id WHERE p.id_user = ? AND f.status = ?', 
                                array(auth()->user()->id, 'NS')));
        }
        return array('numberOfActiveFixtures' => $numberOfActiveFixtures, 'numberOfPredictions' => $numberOfPredictions);
    }


    private function getOverallPrediction() {
        $overallPrediction = null;
        if (auth()->user()) {
            $overallPrediction = User::join('overall_predictions', 'overall_predictions.id_user', '=', 'users.id')
                                    ->join('teams', 'teams.id', '=', 'overall_predictions.id_team')
                                    ->where('users.id', '=', Auth::id())
                                    ->get();
        }

        return $overallPrediction == null ? array() : $overallPrediction;

    }

    private function getReceivedMessages($id) {
        return User::find($id)
                ->receivedMessages()
                ->join('users', 'users.id', '=', 'private_messages.id_sender')
                ->where('private_messages.opened', '=', '0')
                ->get();
    }


}
