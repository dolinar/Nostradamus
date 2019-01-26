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

        $invitations = $this->getInvitations();

        $data = [
            'difference' => $predictionsData['numberOfActiveFixtures'] - $predictionsData['numberOfPredictions'],
            'posts' => $postsArray,
            'overallPrediction' => $overallPrediction,
            'fixtures' => $fixtures,
            'topFive' => $topFive,
            'invitations' => $invitations,
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
        return User::where(function ($query) {
                        $query->where('status', 1)->orWhere('status', 0);
                    })
                    ->select('users.username', 'user_data_flow.points_total', 'user_data_flow.position')
                    ->join('user_data_flow', 'users.id', '=', 'user_data_flow.id_user')
                    ->where('user_data_flow.id_matchday', '=', $this->getMatchdayId()[0])
                    ->take(5)->get();
            
    }

    public function getInvitations() {
        $invitations = array();

        if (auth()->user()) {
            $invitations = DB::table('group_invitations')
                ->select('group_invitations.id', 'u1.username as user', 'u2.username as user_invitator', 'groups.name')
                ->join('users as u1',  'group_invitations.id_user', '=', 'u1.id')
                ->join('users as u2',  'group_invitations.id_user_invitator', '=', 'u2.id')
                ->join('groups', 'group_invitations.id_group', '=', 'groups.id')
                ->where('group_invitations.id_user', '=', auth()->user()->id)
                ->where('group_invitations.status', '=', '0')
                ->get()->toArray();
        }

        return $invitations;
    }

    private function getMatchdayId() {
        return Matchday::where('finished', 1)
                       ->orderBy('id', 'DESC')
                       ->limit(1)
                       ->pluck('id');
    }
}
