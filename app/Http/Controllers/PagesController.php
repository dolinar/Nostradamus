<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Custom\BlogFeed;
use App\OverallPrediction;
use App\Matchday;
use App\User;
use App\Fixture;
use App\Prediction;

class PagesController extends Controller
{
    public function index() 
    {
        // news 
        $blogFeed = new BlogFeed("https://www.uefa.com/rssfeed/uefachampionsleague/rss.xml");
        $postsArray = $blogFeed->posts;
        $postsArray = array_slice($postsArray, 0, 5);

        // overall prediction reminder
        $overallPrediction = array();
        if (auth()->user()) {
            $overallPrediction = User::find(auth()->user()->id)->overallPrediction;
        }

        // next matchday
        $matchday = Matchday::where('finished', 0)->orderBy('date', 'asc')->limit(1)->first();
        // TODO: figure out why fixtures.teams doesnt work
        $fixtures = Matchday::with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->find($matchday->id);

        // Check if count of all current fixtures is greater than number of user's number of ACTIVE predictions
        $numberOfActiveFixtures = count(Fixture::where('status', 'NS')->get());
        $numberOfPredictions = count(DB::select('SELECT * FROM predictions p LEFT JOIN fixtures f ON p.id_fixture = f.id WHERE p.id_user = ? AND f.status = ?', 
                            array(auth()->user()->id, 'NS')));
        $data = [
            'difference' => $numberOfActiveFixtures - $numberOfPredictions,
            'posts' => $postsArray,
            'overallPrediction' => $overallPrediction,
            'fixtures' => $fixtures->toArray()
        ];  
        return view('pages.index')->with("data", $data);
    }

    public function info() 
    {
        return view('pages.info');
    }

    public function instructions() 
    {
        return view('pages.instructions');
    }

    public function table() 
    {
        return view('pages.table');
    }

    public function results() 
    {
        return view('pages.results');
    }

    public function clDraw() 
    {
        return view('pages.cl_draw');
    }

    public function clStatistics() 
    {
        return view('pages.cl_statistics');
    }
}
