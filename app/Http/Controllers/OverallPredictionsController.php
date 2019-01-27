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
        $this->middleware(['auth', 'verified']);
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
        // fetch team data
        $overallPredictionTeam = (!is_null($overallPrediction)) ? OverallPrediction::find($overallPrediction->id)->team : array();
        $overallPrediction = (is_null($overallPrediction) ? array() : $overallPrediction);
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
        $overallPrediction = new OverallPrediction;
        $overallPrediction->id_user = auth()->user()->id;
        $overallPrediction->id_team = intval($request->ekipa);
        $overallPrediction->save();

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
        $overallPrediction = OverallPrediction::find($id);
        $overallPrediction->id_team = intval($request->ekipa);
        $overallPrediction->save();

        return redirect('/overall_prediction')->with('success', 'Napoved končnega zmagovalca posodobljena!');
    }
}
