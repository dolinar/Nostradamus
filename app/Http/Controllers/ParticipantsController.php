<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Matchday;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{
    public function index() { 
        $idMatchday = $this->getMatchdayId();
        $participants = User::where(function ($query) {
                                $query->where('status', 1)->orWhere('status', 0);
                            })
                            ->select('users.id', 'users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                            ->leftJoin('user_data_flow AS u1', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u1.id_user');
                                $join->where('u1.id_matchday', '=', $idMatchday);
                            })
                            ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u2.id_user');
                                $join->where('u2.id_matchday', '=', $idMatchday == 0 ? 0 : $idMatchday - 1);
                            })
                            ->orderByRaw('ISNULL(u1.position), u1.position ASC')
                            ->paginate(10)
                            ->setPath('table');

        $user = $this->getAuthenticatedUser();
 
        $data = [
            'participants' => $participants,
            'user' => $user,
        ];

        return view('participants.index')->with('data', $data);
    }

    private function getAuthenticatedUser() {
        $idMatchday = $this->getMatchdayId();
        $authenticated = auth()->user();

        if ($authenticated) {
            $username = $authenticated->username;

            $user = User::where('username', $username)
                        ->select('users.id', 'users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                        ->leftJoin('user_data_flow AS u1', function($join) use($idMatchday) {
                            $join->on('users.id', '=', 'u1.id_user');
                            $join->where('u1.id_matchday', '=', $idMatchday);
                        })
                        ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                            $join->on('users.id', '=', 'u2.id_user');
                            $join->where('u2.id_matchday', '=', $idMatchday == 0 ? 0 : $idMatchday - 1);
                        })
                        ->get(); 
            return $user;
        }
        
        return null;
    }
    
    public function search(Request $request) {
        $idMatchday = $this->getMatchdayId();
        $search = $request->input('text');

        if (is_null($search) || strcmp($search, '') == 0) {
            $data = $this->index()->render();
            return response()->json(array('success' => true, 'search' => $search, 'html' => $data));
        }

        $participants = User::where(function ($query) {
                                $query->where('status', 1)->orWhere('status', 0);
                            })    
                            ->where('users.username', 'like', '%' . $search . '%')
                            ->select('users.id', 'users.username', 'users.name', 'u1.points_total', 'u1.points_matchday', 'u1.position', 'u2.position AS last_position')
                            ->leftJoin('user_data_flow AS u1', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u1.id_user');
                                $join->where('u1.id_matchday', '=', $idMatchday);
                            })
                            ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                                $join->on('users.id', '=', 'u2.id_user');
                                $join->where('u2.id_matchday', '=', $idMatchday == 0 ? 0 : $idMatchday - 1);
                            })
                            ->orderByRaw('ISNULL(u1.position), u1.position ASC')
                            ->paginate(10)
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
        $id = Matchday::where('finished', 1)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->pluck('id');
        return count($id) == 0 ? 0 : $id[0];
    }
}
