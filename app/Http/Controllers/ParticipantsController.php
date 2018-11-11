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
                            ->paginate(10);
        $data = [
            'participants' => $participants
        ];

        return view('participants.table')->with('data', $data);
    }

    
}
