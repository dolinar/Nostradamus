<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fixture;
use App\Matchday;

class FixturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $results = DB::select('SELECT m.date, f.id_matchday, f.time, f.home_score, f.away_score, f.status, t.name AS home_team, t2.name as away_team 
                                FROM matchdays m INNER JOIN fixtures f ON m.id = f.id_matchday 
                                    INNER JOIN teams t ON f.home_team = t.id 
                                    INNER JOIN teams t2 ON f.away_team = t2.id 
                                        WHERE f.status = ?', array('FT'));
        $matchdays = Matchday::where('finished', true)->get();
        $data = [
            'results' => $results,
            'matchdays' => $matchdays
        ];
        return view('pages.cl_results')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
