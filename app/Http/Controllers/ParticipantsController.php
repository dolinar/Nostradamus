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
                            ->paginate(5);
        
        $user = $this->getAuthenticatedUser();
        $data = [
            'participants' => $participants,
            'user' => $user
        ];



        return view('participants.table')->with('data', $data);
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
    
}
