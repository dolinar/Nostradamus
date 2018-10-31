<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ParticipantsController extends Controller
{
    public function index() {
        $participants = User::where('status', 1)->paginate(1);
        $data = [
            'participants' => $participants
        ];
        return view('participants.table')->with('data', $data);
    }

    
}
