<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Matchday;
use Auth;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show($id) {
        $user = User::find($id)
                ->select('users.id', 'users.username', 'users.profile_image', 'users.created_at AS user_created_at', 'logins.created_at')
                ->join('logins', function($join) use($id) {
                    $join->on('users.id', '=', 'logins.id_user');
                    $join->where('logins.id_user', '=', $id);
                })
                ->orderBy('logins.id', 'DESC')
                ->take(1)
                ->get();

        $userData = User::find($id)
                    ->join('user_data_flow', function($join) use($id) {
                        $join->on('users.id', '=', 'user_data_flow.id_user');
                        $join->where('user_data_flow.id_user', '=', $id);
                    })
                    ->orderBy('user_data_flow.id', 'DESC')
                    ->take(1)
                    ->get();
         
        $predictions = $this->getPredictions(1, $id);

        $activePredictions = $this->getPredictions(0, $id);
                        
        $data = [
            'user' => $user,
            'predictions' => $predictions,
            'activePredictions' => $activePredictions,
            'userData' => $userData
        ];

        return view('profile.show')->with('data', $data);
    }

    private function getPredictions($matchdayFinished, $id) {
        return Matchday::where('finished', '=', $matchdayFinished)
                ->with(['fixtures', 'fixtures.teamHome', 'fixtures.teamAway', 'fixtures.prediction' => function($q) use($id) {
                    $q->where('id_user', $id);
                }])
                ->orderBy('matchdays.id', 'DESC')
                ->get();

    }

}
