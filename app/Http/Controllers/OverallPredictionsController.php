<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\OverallPrediction;
use App\Team;
class OverallPredictionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::where('status', 1)->orWhere('status', 0)->get();
        $overallPrediction = DB::select('SELECT t.name, op.id
                                            FROM teams t INNER JOIN overall_predictions op 
                                                ON t.id = op.id_team 
                                                    WHERE op.id_user = ?', array(auth()->user()->id));
        $data = [
            'teams' => $teams,
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
