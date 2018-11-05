<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matchday;
use App\Prediction;
use Illuminate\Support\Facades\DB;
class PredictionsController extends Controller
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
        $predictions = Matchday::where('finished', '=', '0')
                                        ->with(['fixtures', 'fixtures.teamHome', 'fixtures.teamAway', 'fixtures.prediction' => function($q) {
                                            $q->where('id_user', auth()->user()->id);
                                        }])
                                        ->get();
        $data = [
            'predictions' => $predictions->toArray(),
        ];
        return view('predictions.index')->with('data', $data);
    }


    /**
     * Store new resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'prediction.*.*' => 'required'
        ], [], [
            'prediction.*.*' => 'goli ekipe',
        ]);
        foreach ($request['prediction'] as $idFixture => $scores) {
            $prediction = new Prediction;
            $prediction->id_user = auth()->user()->id;
            $prediction->id_fixture = $idFixture;
            $prediction->prediction_home = $scores['home'];
            $prediction->prediction_away = $scores['away'];
            $prediction->save();
        }
        return redirect('/predictions')->with('success', 'Napovedi shranjene!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prediction = Prediction::with('fixture', 'fixture.teamHome', 'fixture.teamAway')->find($id);
        if (auth()->user()->id !== $prediction->id_user) {
            return redirect('/predictions');
        }
        return view('predictions.edit')->with('prediction', $prediction->toArray());
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
            'home' => 'required',
            'away' => 'required'
        ], [], [
            'home' => 'napoved',
            'away' => 'napoved'
        ]);

        $prediction = Prediction::find($id);
        $prediction->prediction_home = $request->home;
        $prediction->prediction_away = $request->away;
        $prediction->save();

        return redirect('/predictions')->with('success', 'Napoved uspešno posodobljena!');
    }
}
