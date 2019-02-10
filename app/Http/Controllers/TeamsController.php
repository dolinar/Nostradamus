<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Matchday;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::orderBy('status', 'DESC')->get();
        return view('teams.index')->with('teams', $teams);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::find($id);
        
        $finishedMatchdays = $this->getMatchdays(1, $id);
        $toBePlayed = $this->getMatchdays(0, $id);
                        
        $data = [
            'team' => $team,
            'matchdays' => $finishedMatchdays,
            'activeMatchdays' => $toBePlayed,
            'id' => $id
        ];                

        return view('teams.show')->with('data', $data);
    }


    private function getMatchdays($finished, $id) {
        return Matchday::where('finished', '=', $finished)
                        ->select('t1.name as home_team', 't2.name as away_team', 
                                    'matchdays.date', 'matchdays.stage', 'matchdays.id as matchday_id',
                                    'fixtures.time', 'fixtures.home_score', 'fixtures.away_score', 
                                    't1.id as home_team_id', 't2.id as away_team_id')
                        ->join('fixtures', 'matchdays.id', '=', 'fixtures.id_matchday')
                        ->join('teams as t1', 'fixtures.home_team', '=', 't1.id')
                        ->join('teams as t2', 'fixtures.away_team', '=', 't2.id')
                        ->where(function ($query) use($id) {
                            $query->where('fixtures.home_team', '=', $id)->orWhere('fixtures.away_team', '=', $id);
                        })
                        ->orderBy('matchdays.id', 'DESC')
                        ->get();
    }
}
