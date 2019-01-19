<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $info = array();
        $groups = $user->groups;
        foreach ($groups as $group) {
            $info[$group->id] = array(
                $group->users->count(), 
                User::find($group['owner'])->username, 
                $this->getTopFiveForGroup($group->id),
                $this->getAuthenticatedUser($group->id)
            );

        }
        $data = [
            'groups' => $groups,
            'info' => $info
        ];
        return view('groups.index')->with('data', $data);
    }

    private function getTopFiveForGroup($groupId) {
        $participants = User::where('status', 1)->orWhere('status', 0)
                            ->select('users.username', 'users.name', DB::raw('SUM(points) as total_points'))
                            ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                            ->join('user_group', function($join) use($groupId) {
                                $join->on('users.id', '=', 'user_group.id_user');
                                $join->where('user_group.id_group', '=', $groupId);
                            })
                            ->groupBy('predictions.id_user', 'users.username', 'users.name')
                            ->orderBy('total_points', 'DESC')
                            ->orderBy('users.username')
                            ->take(5)->get();
        return $participants;
    }

    
    private function getAuthenticatedUser($groupId) {
        $authenticated = auth()->user();

        if ($authenticated) {
            $username = $authenticated->username;
            $users = User::where('status', 1)->orWhere('status', 0)
                        ->select('users.username', 'users.name', DB::raw('SUM(points) as total_points'))
                        ->leftJoin('predictions', 'users.id', '=', 'predictions.id_user')
                        ->join('user_group', function($join) use($groupId) {
                            $join->on('users.id', '=', 'user_group.id_user');
                            $join->where('user_group.id_group', '=', $groupId);
                        })
                        ->groupBy('predictions.id_user', 'users.username', 'users.name')
                        ->orderBy('total_points', 'DESC')
                        ->orderBy('users.username')
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
            if ($position + 1 >= 5) {
                return $user;
            } else {
                return null;
            }
        }
    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'group_name' => 'required'
        ]);
        $exists = Group::where('name', '=', $request->group_name)->get();
        if (count($exists)) {
            return redirect('/groups')->with('error', 'Skupina s tem imenom že obstaja!');
        }
        
        $numberOfGroups = Group::where('owner', '=', auth()->user()->id)->count();

        if ($numberOfGroups >= 5) {
            return redirect('/groups')->with('error', 'Vsak uporabnik je lahko lastnik največ 5 skupin!');
        }

        $group = new Group;
        $group->name = $request->group_name;
        $group->owner = auth()->user()->id;

        $group->save();
        $group->users()->attach(auth()->user()->id, array('user_status' => 1));
        return redirect('/groups')->with('success', 'Skupina uspešno kreirana!');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find(auth()->user()->id);
        $partOfGroup = $user->groups()->wherePivot('id_group', '=', $id)->get();
        
        $group = Group::find($id);

        $data = [
            'group' => $group
        ];
        if (count($partOfGroup) > 0) {
            return view('groups.show')->with('data', $data);
        } else {
            return redirect('/groups');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
