<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;
use App\Prediction;
use Illuminate\Support\Facades\DB;
use App\User;

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
        $predictionsData = $this->getPredictionsData();
        $overallPrediction = $this->getOverallPrediction();
        $invitations = $this->getInvitations();

        $data = [
            'overallPrediction' => $overallPrediction,
            'invitations' => $invitations,
            'difference' => $predictionsData['numberOfActiveFixtures'] - $predictionsData['numberOfPredictions'],
        ];
        return view('dashboard')->with('data', $data);
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
                ->get()->toArray();
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
            $overallPrediction = User::find(auth()->user()->id)->overallPrediction;
        }
        return $overallPrediction == null ? array() : $overallPrediction;

    }
}
