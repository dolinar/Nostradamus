<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Matchday;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{
    public function index() {
        $idMatchday = $this->getMatchdayId()[0];
        $participants = User::where(function ($query) {
                                $query->where('status', 1)->orWhere('status', 0);
                            })
                            ->where('u1.id_matchday', '=', $idMatchday)
                            ->select('users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                            ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')
                            ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u2.id_user');
                                $join->where('u2.id_matchday', '=', $idMatchday - 1);
                            })
                            ->orderBy('u1.position')
                            ->paginate(5)
                            ->setPath('table');
        //return $participants;

        $user = $this->getAuthenticatedUser();

        $data = [
            'participants' => $participants,
            'user' => $user,
        ];

        return view('participants.index')->with('data', $data);
    }

    private function getAuthenticatedUser() {
        $idMatchday = $this->getMatchdayId()[0];
        $authenticated = auth()->user();

        if ($authenticated) {
            $username = $authenticated->username;

            $user = User::where('username', $username)
                        ->where('u1.id_matchday', '=', $idMatchday)     
                        ->select('users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                        ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')
                        ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                            $join->on('users.id', '=', 'u2.id_user');
                            $join->where('u2.id_matchday', '=', $idMatchday - 1);
                        })
                        ->orderBy('u1.position')
                        ->get(); 
            return $user;
        }
        
        return null;
    }
    
    public function search(Request $request) {
        $idMatchday = $this->getMatchdayId()[0];
        $search = $request->input('text');

        if (is_null($search) || strcmp($search, '') == 0) {
            $data = $this->index()->render();
            return response()->json(array('success' => true, 'search' => $search, 'html' => $data));
        }

        $participants = User::where(function ($query) {
                                $query->where('status', 1)->orWhere('status', 0);
                            })
                            ->where('u1.id_matchday', '=', $idMatchday)         
                            ->where('users.username', 'like', '%' . $search . '%')
                            ->select('users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                            ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')
                            ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u2.id_user');
                                $join->where('u2.id_matchday', '=', $idMatchday - 1);
                            })
                            ->orderBy('u1.position')
                            ->paginate(5)
                            ->setPath('table');

        $user = $this->getAuthenticatedUser();

        $data = [
            'participants' => $participants,
            'user' => $user,
        ];

        $returnHTML = view('participants.table')->with('data', $data)->render();
        return response()->json(array('success' => true, 'search' => $search, 'html' => $returnHTML));
    }

    private function getMatchdayId() {
        return Matchday::where('finished', 1)
                       ->orderBy('id', 'DESC')
                       ->limit(1)
                       ->pluck('id');
    }
}
