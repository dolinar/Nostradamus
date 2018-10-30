<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\OverallPrediction;
use App\Team;
use App\User;

class OverallPredictionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // fetch all teams
        $teams = Team::All();

        // fetch overall prediction of an authorized user
        $overallPrediction = User::find(auth()->user()->id)->overallPrediction;

        // fetch current selected team's data
        $overallPredictionTeam = OverallPrediction::find($overallPrediction->id)->team;

        $data = [
            'teams' => $teams,
            'overallPredictionTeam' => $overallPredictionTeam,
            'overallPrediction' => $overallPrediction
        ];
        return view('overallpredictions.index')->with('data', $data);
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
            'ekipa' => 'required'
        ]);
        $overallPredictionStore = new OverallPrediction;
        $overallPredictionStore->id_user = auth()->user()->id;
        $overallPredictionStore->id_team = intval($request->ekipa);
        $overallPredictionStore->save();

        return redirect('/overall_prediction')->with('success', 'Napoved končnega zmagovalca shranjena!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ekipa' => 'required'
        ]);
        $overallPredictionUpdate = OverallPrediction::find($id);
        $overallPredictionUpdate->id_team = intval($request->ekipa);
        $overallPredictionUpdate->save();

        return redirect('/overall_prediction')->with('success', 'Napoved končnega zmagovalca posodobljena!');
    }
}
