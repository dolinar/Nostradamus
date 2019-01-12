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

        $overallPrediction = $this->getOverallPrediction();

        $fixtures = $this->getNextMatchday();

        $predictionsData = $this->getPredictionsData();

        $topFive = $this->getTopFive();

        $user = $this->getAuthenticatedUserIfNotInTopFive($topFive);

        $data = [
            'difference' => $predictionsData['numberOfActiveFixtures'] - $predictionsData['numberOfPredictions'],
            'posts' => $postsArray,
            'overallPrediction' => $overallPrediction,
            'fixtures' => $fixtures,
            'topFive' => $topFive,
            'user' => $user
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

    private function getOverallPrediction() {
        $overallPrediction = null;
        if (auth()->user()) {
            $overallPrediction = User::find(auth()->user()->id)->overallPrediction;
        }
        return $overallPrediction == null ? array() : $overallPrediction;

    }

    private function getNextMatchday() {
        // next matchday
        $matchday = Matchday::where('finished', 0)->orderBy('date', 'asc')->limit(1)->first();
        // TODO: figure out why fixtures.teams doesnt work
        return $matchday ? Matchday::with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway')->find($matchday->id)->toArray() : array();
    }

    private function getPredictionsData() {
        // Check if count of all current fixtures is greater than number of user's number of ACTIVE predictions
        $numberOfActiveFixtures = 0;
        $numberOfPredictions = 0;
        if (auth()->user()){
            $numberOfActiveFixtures = count(Fixture::where('status', 'NS')->get());
            $numberOfPredictions = count(DB::select('SELECT * FROM predictions p LEFT JOIN fixtures f ON p.id_fixture = f.id WHERE p.id_user = ? AND f.status = ?', 
                                array(auth()->user()->id, 'NS')));
        }
        return array('numberOfActiveFixtures' => $numberOfActiveFixtures, 'numberOfPredictions' => $numberOfPredictions);
    }

    private function getTopFive() {
        return  
            User::where('status', 1)->orWhere('status', 0)
                ->select('users.username', DB::raw('SUM(points) as total_points'))
                ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                ->groupBy('predictions.id_user', 'users.username')
                ->orderBy('total_points', 'DESC')
                ->take(5)->get();
    }

    private function getAuthenticatedUserIfNotInTopFive($topFive) {
        $isTopFive = false;
        $authenticated = auth()->user();
        foreach ($topFive as $user) {
            if ($authenticated && $user->username === auth()->user()->username) {
                $isTopFive = true;
                break;
            }
        }

        if (!$isTopFive && $authenticated) {
            $username = $authenticated->username;
            $users =  User::where('status', 1)->orWhere('status', 0)
                        ->select('users.username', DB::raw('SUM(points) as total_points'))
                        ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                        ->groupBy('predictions.id_user', 'users.username')
                        ->orderBy('total_points', 'DESC')
                        ->get();

            $position = $users->search(function ($users, $key) use ($username) {
                return $users->username == $username;
            });

            $user = User::where('username', $username)
                        ->select('users.username', DB::raw('SUM(points) as total_points'))
                        ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                        ->groupBy('predictions.id_user', 'users.username')
                        ->orderBy('total_points', 'DESC')
                        ->get(); 

            $user['position'] = $position+1;
            return $user;
        }
        
        return null;
    }
}
