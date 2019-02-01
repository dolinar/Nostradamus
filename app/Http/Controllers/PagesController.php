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
        $postsArray = $this->getPostsArray();
        $fixtures = $this->getNextMatchday();
        $topFive = $this->getTopFive();
        

        $data = [

            'posts' => $postsArray,
            'fixtures' => $fixtures,
            'topFive' => $topFive,

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

    private function getPostsArray() {
        $blogFeed = new BlogFeed("https://www.uefa.com/rssfeed/uefachampionsleague/rss.xml");
        $postsArray = $blogFeed->posts;
        return array_slice($postsArray, 0, 5);
    }


    private function getNextMatchday() {
        // next matchday
        $matchday = Matchday::where('finished', 0)->orderBy('date', 'asc')->limit(1)->first();
        // TODO: figure out why fixtures.teams doesnt work
        return $matchday ? Matchday::with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->find($matchday->id)->toArray() : array();
    }


    private function getTopFive() {
        return User::where(function ($query) {
                        $query->where('status', 1)->orWhere('status', 0);
                    })
                    ->select('users.id', 'users.username', 'user_data_flow.points_total', 'user_data_flow.position')
                    ->join('user_data_flow', 'users.id', '=', 'user_data_flow.id_user')
                    ->where('user_data_flow.id_matchday', '=', $this->getMatchdayId()[0])
                    ->take(5)->get();
            
    }

    private function getMatchdayId() {
        return Matchday::where('finished', 1)
                       ->orderBy('id', 'DESC')
                       ->limit(1)
                       ->pluck('id');
    }
}
