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
    public function indexResults()
    {
        // finished fixtures
        $results =  Matchday::where('finished', '=', 1)->with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')
            ->orderBy('id', 'DESC')->get();
        $data = [
            'results' => $results->toArray(),
        ];
        return view('pages.cl_results')->with('data', $data);
    }

    public function indexDraw() {
        // to be played
        $draw =  Matchday::where('finished', '=', 0)->with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->orderBy('id', 'DESC')->get();
        $data = [
            'draw' => $draw->toArray(),
        ];
        return view('pages.cl_draw')->with('data', $data);
    }
}