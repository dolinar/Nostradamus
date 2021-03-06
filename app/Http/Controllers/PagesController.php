<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Custom\BlogFeed;
use App\OverallPrediction;
use App\Matchday;
use App\User;
use App\Fixture;
use App\News;
use App\Prediction;
use App\ChatroomMessage;
use App\Charts\SampleChart;
use App\LivescoreApi\GetLiveScores;

class PagesController extends Controller
{

    public function index() 
    {

        //$api = new GetLiveScores;

        $news = $this->getNews();
        $fixtures = $this->getNextMatchday();
    
        $topFive = $this->getTopFive();
        $chatroomMessages = $this->getChatroomMessages();
        $liveFixtures = $this->getLiveFixtures();
        
        $data = [

            'posts' => $news,
            'fixtures' => $fixtures,
            'topFive' => $topFive,
            'chatroomMessages' => $chatroomMessages,
            'liveFixtures' => $liveFixtures

        ];  
        return view('pages.index.index')->with("data", $data);
    }


    public function info() 
    {
        $chart = $this->getOverallPredictionsChart();
        $users = $this->getUsersChart();
        $registrations = $this->getUsersThroughTime();
        $predictions = $this->getPredictionsPoints();

        $data = [
            'chart' => $chart,
            'users' => $users,
            'registrations' => $registrations,
            'predictions' => $predictions
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

    private function getNews() {
        $news = News::join('news_type', 'news.news_type_id', 'news_type.id')
            ->join('users', 'news.id_user', 'users.id')
            ->select('news.id', 'users.username', 'news_type.name', 'news.title', 'news.summary', 'news.img_ref', 'news.created_at')
            ->limit(4)
            ->orderBy('news.id', 'desc')
            ->get();

        return $news;
    }

    // private function getPostsArray() {
    //     $blogFeed = new BlogFeed("https://www.uefa.com/rssfeed/uefachampionsleague/rss.xml");
    //     $postsArray = $blogFeed->posts;
    //     return array_slice($postsArray, 0, 5);
    // }

    

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

    private function getPredictionsPoints() {
        $predictionsCount = Prediction::whereNotNull('points')->count();
        $predictionsCountNull = Prediction::whereNull('points')->count();
        $predictions = Prediction::select(DB::raw('count(predictions.points) as predictions_count, predictions.points'))
            ->groupBy('points')
            ->whereNotNull('predictions.points')
            ->get();
        $points = ['0 Točk', '1 Točka', '3 Točke'];
        $predictionsCounts = [];

        foreach ($predictions as $prediction) {
            $predictionsCounts[] = $prediction['predictions_count'];
        }
        $chart = new SampleChart;
        $chart->title('Napovedi - skupno število napovedi za končane tekme: '. $predictionsCount . '. Skupaj napovedi: ' . ($predictionsCountNull + $predictionsCount))
                ->labels($points)
                ->dataset('', 'bar', $predictionsCounts)
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
              ->options(['color' => ['#686868', '#50B432', '#ED561B', '#DDDF00', '#686868', '#64E572', '#FF9655', '#FFF263', '#6AF9C4', '#5d82bf', '#73ba7b', '#73bab2', '#e2ae5a', '#a966e8', '#ff87fb']]);
        
        return $chart;
    }

    private function getNextMatchday() {
        // next matchday
        $matchday = Matchday::where('finished', 0)->orderBy('date', 'asc')->limit(1)->first();
        // TODO: figure out why fixtures.teams doesnt work
        return $matchday ? Matchday::with('fixtures', 'fixtures.teamHome', 'fixtures.teamAway', 'fixtures.usersPrediction')
                            ->find($matchday->id)
                            ->toArray() : array();
    }


    private function getTopFive() {
        return User::where(function ($query) {
                        $query->where('status', 1)->orWhere('status', 0);
                    })
                    ->select('users.id', 'users.username', 'users.profile_image', 'user_data_flow.points_total', 'user_data_flow.position')
                    ->join('user_data_flow', 'users.id', '=', 'user_data_flow.id_user')
                    ->where('user_data_flow.id_matchday', '=', $this->getMatchdayId())
                    ->take(5)->get();
            
    }

    private function getChatroomMessages() {

        return ChatroomMessage::with('user')->latest()->take(10)->get();
    }

    private function getMatchdayId() {
        $id = Matchday::where('finished', 1)
                       ->orderBy('id', 'DESC')
                       ->limit(1)
                       ->pluck('id');
        return count($id) == 0 ? 0 : $id[0];
    }

    private function getLiveFixtures() {
        $matchday = Matchday::where('finished', 0)->orderBy('date', 'asc')->limit(1)->first();
        return $matchday 
                ? Fixture::with('matchday', 'teamHome', 'teamAway')
                            ->where('fixtures.status', 'IN_PLAY')
                            ->orWhere('fixtures.status', 'ADDED_TIME')
                            ->orWhere('fixtures.status', 'HALF_TIME_BREAK')
                            ->get() 
                : array();
    }
}
