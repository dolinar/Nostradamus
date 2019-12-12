<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fixture;
use App\Matchday;
use App\MatchStats;
use App\MatchEvent;

class FixturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexResults()
    {
        // finished fixtures
        $results =  Matchday::where('finished', '=', 1)->with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->get();
        $data = [
            'results' => $results->toArray(),
        ];
        return view('pages.cl_results')->with('data', $data);
    }

    public function indexDraw() {
        // to be played
        $draw =  Matchday::where('finished', '=', 0)->with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->get();
        $data = [
            'draw' => $draw->toArray(),
        ];
        return view('pages.cl_draw')->with('data', $data);
    }

    public function showLiveMatch($id) {
        $fixture = Fixture::with('matchday', 'teamHome', 'teamAway')->find($id);
        $idMatch = $fixture->id_match;
        $matchStats = MatchStats::find($idMatch);
        $matchEvents = MatchEvent::where('id_match', $idMatch)->get();

        $data = [
            'fixture' => $fixture,
            'matchStats' => $matchStats,
            'matchEvents' =>$matchEvents
        ];
        return view('pages.live_match')->with('data', $data);
    }
}