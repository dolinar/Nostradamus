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
use App\Charts\SampleChart;

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
        $chart = $this->getOverallPredictionsChart();
        $users = $this->getUsersChart();
        $registrations = $this->getUsersThroughTime();
        $data = [
            'chart' => $chart,
            'users' => $users,
            'registrations' => $registrations
        ];
        return view('pages.info')->with('data', $data);
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

    

    private function getUsersChart() {
        $users = User::count();
        $usersInCompetition = User::where('status', 1)->whereNotNull('email_verified_at')->count();

        $chart = new SampleChart;
        $chart->title('Uporabniki')
              ->labels(['Število uporabnikov', 'Število tekmovalcev'])
              ->dataset('', 'bar', [$users, $usersInCompetition])
              ->options(['showInLegend' => false]);
        return $chart;
    }
    
    private function getUsersThroughTime() {
        $registrations = User::select(DB::raw('count(users.id) as user_count, DATE(users.created_at) as date_created'))
            ->groupBy('date_created')
            ->get();

        $counts = [];
        $dates = [];
        foreach ($registrations as $registration) {
            $counts[] = $registration['user_count'];
            $dates[] = $registration['date_created'];
        }
        
        $chart = new SampleChart;
        $chart->title('Število registracij')
                ->labels($dates)
                ->dataset('', 'bar', $counts)
                ->options(['showInLegend' => false]);
            
        return $chart;
    }

    private function getOverallPredictionsChart() {
        $overallPredictons = OverallPrediction::select(DB::raw('count(teams.id) as teams, teams.name'))
                                            ->join('teams', 'teams.id', '=', 'overall_predictions.id_team')  
                                            ->groupBy('teams.id', 'teams.name')
                                            ->get();
        
        $counts = [];
        $teams = [];
        foreach ($overallPredictons as $overallPredicton) {
            $counts[] = $overallPredicton['teams'];
            $teams[] = $overallPredicton['name'];
        }
        $chart = new SampleChart;
        $chart->title('Napoved končnega tekmovalca')
              ->labels($teams)
              ->dataset('Število napovedi', 'pie', $counts)
              ->options(['color' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4', '#5d82bf', '#73ba7b', '#73bab2', '#e2ae5a', '#a966e8', '#ff87fb']]);
        
        return $chart;
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
                    ->where('user_data_flow.id_matchday', '=', $this->getMatchdayId())
                    ->take(5)->get();
            
    }

    private function getMatchdayId() {
        $id = Matchday::where('finished', 1)
                       ->orderBy('id', 'DESC')
                       ->limit(1)
                       ->pluck('id');
        return count($id) == 0 ? 0 : $id[0];
    }
}
