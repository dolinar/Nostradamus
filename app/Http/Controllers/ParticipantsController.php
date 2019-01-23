<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{
    public function index() {
        $participants = User::where('status', 1)->orWhere('status', 0)
                            ->select('users.username', 'users.name', DB::raw('SUM(points) as total_points'))
                            ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                            ->groupBy('predictions.id_user', 'users.username', 'users.name')
                            ->orderBy('total_points', 'DESC')
                            ->orderBy('users.username')
                            ->paginate(5);
        

        $lastWeek = $this->getLastWeekResults();

        $user = $this->getAuthenticatedUser();

        $data = [
            'participants' => $participants,
            'lastWeek' => $lastWeek,
            'user' => $user,
        ];



        return view('participants.index')->with('data', $data);
    }

    private function getAuthenticatedUser() {
        $authenticated = auth()->user();

        if ($authenticated) {
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
    
    public function search(Request $request) {
        $search = $request->input('text');
        if (is_null($search) || strcmp($search, '') == 0) {
            $data = $this->index()->render();
            return response()->json(array('success' => true, 'search' => $search, 'html' => $data));
        }

        $participants = User::where(function ($query) {
            $query->where('status', 1)->orWhere('status', 0);
        })
            ->select('users.username', 'users.name', DB::raw('SUM(points) as total_points'))
            ->where('users.username', 'like', '%' . $search . '%')
            ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
            ->groupBy('predictions.id_user', 'users.username', 'users.name')
            ->orderBy('total_points', 'DESC')
            ->orderBy('users.username')
            ->paginate(5);


        $user = $this->getAuthenticatedUser();

        $lastWeek = $this->getLastWeekResults();

        $data = [
            'participants' => $participants,
            'lastWeek' => $lastWeek,
            'user' => $user,
        ];


        $returnHTML = view('participants.table')->with('data', $data)->render();
        return response()->json(array('success' => true, 'search' => $search, 'html' => $returnHTML));
    }

    public function getLastWeekResults() {
        $q = User::where('users.status', '<', 2)
            ->select('users.username', DB::raw('SUM(points) as total_points'))
            ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
            ->join('fixtures', 'predictions.id_fixture', '=', 'fixtures.id')
            ->join('matchdays', 'fixtures.id_matchday', '=', 'matchdays.id')
            ->where('matchdays.id', '=', function($query) {
                $query->select('id')->from('matchdays')->orderBy('id', 'DESC')->where('finished', 1)->limit(1);
            })->groupBy('users.id', 'users.username')->get();

        $lastWeek = array();
        foreach ($q as $a) {
            $lastWeek[$a['username']] = $a['total_points'];
        }
        return $lastWeek;
    }
}
