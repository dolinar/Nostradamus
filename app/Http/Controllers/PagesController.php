<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Custom\BlogFeed;
use App\OverallPrediction;
use App\Matchday;

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
            $overallPrediction = DB::select('SELECT t.name, op.id
                                    FROM teams t INNER JOIN overall_predictions op 
                                        ON t.id = op.id_team 
                                            WHERE op.id_user = ?', array(auth()->user()->id));
        }

        // next matchday
        $matchday = Matchday::orderBy('date', 'asc')->limit(1)->get();

        $matchdayId = $matchday[0]->id;
        $fixtures = DB::select('SELECT m.date, f.time, f.status, t.name AS home_team, t2.name as away_team 
                                    FROM matchdays m INNER JOIN fixtures f ON m.id = f.id_matchday 
                                        INNER JOIN teams t ON f.home_team = t.id 
                                        INNER JOIN teams t2 ON f.away_team = t2.id 
                                            WHERE m.id = ?', array($matchdayId));
        $data = [
            'posts' => $postsArray,
            'overallPrediction' => $overallPrediction,
            'matchday' => $matchday,
            'fixtures' => $fixtures
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

    public function clResults() 
    {
        return view('pages.cl_results');
    }

    public function clStatistics() 
    {
        return view('pages.cl_statistics');
    }
}
