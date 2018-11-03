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
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
