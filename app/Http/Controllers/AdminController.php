<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matchday;
use App\Team;
use App\Fixture;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index() {
        $teams = Team::pluck('name', 'id')->toArray();
        $matchdays = Matchday::pluck('date', 'id')->toArray();
        $nextFixture = Fixture::where('status', 'NS')->with(['teamHome', 'teamAway'])->first();

        $data = [
            'matchdays' => $matchdays,
            'teams' => $teams,
            'nextFixture' => $nextFixture
        ];
        return view('admin.index')->with('data', $data);
    }

    public function createMatchday(Request $request) {
        $matchday = new Matchday;
        $matchday->date = $request['date'];
        $matchday->stage = $request['stage'];
        $matchday->finished = 0;
        $matchday->save();

        return redirect('/admin')->with('success', 'Tekmovalni dan shranjen.');
    }

    public function createFixture(Request $request) {
        $fixture = new Fixture;
        $fixture->home_team = $request['team1_select'];
        $fixture->away_team = $request['team2_select'];
        $fixture->id_matchday = $request['matchday_select'];
        $fixture->time = $request['start_time'];
        $fixture->status = 'NS';

        $fixture->save();

        return redirect('/admin')->with('success', 'Nova tekma shranjena.');
    }

    public function finishFixture(Request $request) {
        $this->validate($request, [
            'home_score' => 'required',
            'away_score' => 'required'
        ]);
        $fixture = Fixture::find($request->id);
        $fixture->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score
        ]);

        return redirect('/admin')->with('success', 'Tekma zaključena.');
    }
}
