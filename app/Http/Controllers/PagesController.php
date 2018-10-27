<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Custom\BlogFeed;
use App\OverallPrediction;

class PagesController extends Controller
{
    public function index() 
    {
        $blogFeed = new BlogFeed("https://www.uefa.com/rssfeed/uefachampionsleague/rss.xml");
        $postsArray = $blogFeed->posts;
        $postsArray = array_slice($postsArray, 0, 5);

        $overallPrediction = array();
        if (auth()->user()) {
            $overallPrediction = DB::select('SELECT t.name, op.id
                                    FROM teams t INNER JOIN overall_predictions op 
                                        ON t.id = op.id_team 
                                            WHERE op.id_user = ?', array(auth()->user()->id));
        }

        $data = [
            'posts' => $postsArray,
            'overallPrediction' => $overallPrediction
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
