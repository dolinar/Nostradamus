<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }



    public function show($id) {
        $user = User::find($id)
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
        $predictions = User::where('users.id', '=', $id)
            ->select(
                    'users.created_at', 
                    't1.name AS home_team', 't2.name AS away_team', 
                    'fixtures.home_score', 'fixtures.away_score',
                    'predictions.prediction_home', 'predictions.prediction_away',
                    'predictions.points')
            ->join('predictions', 'users.id', '=', 'predictions.id_user')
            ->join('fixtures', 'predictions.id_fixture', '=', 'fixtures.id')
            ->join('teams AS t1', 'fixtures.home_team', '=', 't1.id')
            ->join('teams AS t2', 'fixtures.away_team', '=', 't2.id')
            ->join('matchdays', function($join) use($matchdayFinished) {
                $join->on('fixtures.id_matchday', '=', 'matchdays.id');
                $join->where('matchdays.finished', '=', $matchdayFinished);
            })
            ->get(); 
        return $predictions;
    }

}
