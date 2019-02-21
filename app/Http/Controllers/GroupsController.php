<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Matchday;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
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
            'info' => $info,

        ];
        return view('groups.index')->with('data', $data);
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
        
        $isAdmin = $user->groups()->wherePivot('id_group', '=', $id)->wherePivot('user_status', '=', 1)->get();

        $group = Group::find($id);
        
        $users = User::pluck('username', 'id')->toArray();

        $participants = $this->getGroupParticipants($id);

        $user = $this->getAuthenticatedUser($id);

        $invitations = $this->getInvitationStatuses($id);

        $data = [
            'group' => $group,
            'users' => $users,
            'participants' => $participants,
            'user' => $user,
            'isAdmin' => (count($isAdmin)) > 0 ? 1 : 0,
            'invitations' => $invitations
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
        $group = Group::find($id);
        $group->delete();
        $group->users()->detach();

        return redirect('/groups')->with('success', 'Skupina uspešno izbrisana!'); 
    }

    public function removeUser(Request $request) {
        $id = $request->id;
        $idGroup = $request->idGroup;
        $user = User::find($id);
        
        $user->groups()->detach($idGroup);

        return redirect('/groups/' . $idGroup)->with('success', 'Uporabnik uspešno odstranjen iz skupine.');
    }

    public function leaveGroup(Request $request) {
        $user = User::find(auth()->user()->id);
        $idGroup = $request->idGroup;
        $group = Group::find($idGroup);

        $user->groups()->detach($idGroup);
        
        return redirect('/groups')->with('success', 'Uspešno ste zapustili skupino' . $group->name . '.');
    }

    public function storeUser(Request $request) {
        $invitationId = $request->id;
        $confirmed = $request->confirmed;

        $invitation =  DB::table('group_invitations')
            ->select('id', 'id_user', 'id_group', 'admin')
            ->where('id', '=', $invitationId)
            ->get();

        if ($confirmed == 1) {
            DB::table('user_group')->insert (
                array(
                    'id_user' => $invitation[0]->id_user,
                    'id_group' => $invitation[0]->id_group,
                    'user_status' => $invitation[0]->admin,
                )
            );
        } 

        $invitation = DB::table('group_invitations')
            ->where('id', '=', $invitation[0]->id)
            ->update(array (
                'status' => ($confirmed == 1) ? 1 : 2
            ));

        if ($confirmed == 1) {
            return redirect('/dashboard')->with('success', 'Uspešno ste bili dodani v skupino!'); 
        } else {
            return redirect('/dashboard')->with('success', 'Povabilo za skupino zavrnjeno.'); 
        }

    }

    public function sendInvitation(Request $request) {
        $idGroup = $request->group_id;
        $idUser = $request->user_id_select;
        $adminCheckbox = ($request->user_checkbox) ? 1 : 0;

        if ($idUser == 0) {
            return redirect('/groups/' . $idGroup)->with('error', 'Izberite uporabnika s seznama.'); 
        }

        if (count(Group::find($idGroup)->users()->where('users.id', '=', $idUser)->get()) > 0) {
            return redirect('/groups/' . $idGroup)->with('error', 'Uporabnik je že v skupini.'); 
        }

        $invitation =  DB::table('group_invitations')
                                ->select('id')
                                ->where([
                                    ['id_group', '=', $idGroup],
                                    ['id_user', '=', $idUser],
                                    ['status', '=', 0]
                                    ])
                                ->get();
        
        if (count($invitation) > 0) {
            return redirect('/groups/' . $idGroup)->with('error', 'Uporabnik je že povabljen!'); 
        }

        DB::table('group_invitations')->insert (
            array(
                'id_group' => $idGroup,
                'id_user' => $idUser,
                'id_user_invitator' => auth()->user()->id,
                'admin' => $adminCheckbox,
                'status' => 0
            )
        );
        return redirect('/groups/' . $idGroup)->with('success', 'Uporabnik je povabljen! Uporabnik mora sedaj povabilo sprejeti.'); 
    }

    private function getGroupParticipants($groupId) {
        $idMatchday = $this->getMatchdayId();
        $participants = User::whereHas('groups', function($query) use($groupId) {
                                $query->where('groups.id', '=', $groupId);
                            })
                            ->where(function ($query) {
                                $query->where('users.status', 1)->orWhere('users.status', 0);
                            })
                            ->where('u1.id_matchday', '=', $idMatchday)
                            ->select('users.id', 'users.username', 'users.name', 'u1.points_total', 'u1.points_matchday')
                            ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')    
                            ->orderBy('u1.position')
                            ->paginate(10);
        return $participants;
    }

    private function getTopFiveForGroup($groupId) {
        $participants = User::where(function ($query) {
                                $query->where('status', 1)->orWhere('status', 0);
                            })
                            ->select('users.username', 'user_data_flow.points_total')
                            ->join('user_group', function($join) use($groupId) {
                                $join->on('users.id', '=', 'user_group.id_user');
                                $join->where('user_group.id_group', '=', $groupId);
                            })
                            ->join('user_data_flow', 'users.id', '=', 'user_data_flow.id_user')
                            ->where('user_data_flow.id_matchday', '=', $this->getMatchdayId())
                            ->take(5)->get();

        return $participants;
    }


    private function getInvitationStatuses($groupId) {
        return DB::table('group_invitations')
                    ->select('users.username', 'group_invitations.status')
                    ->where('id_user_invitator', '=', auth()->user()->id)
                    ->where('id_group', '=', $groupId)
                    ->join('users', 'users.id', '=', 'group_invitations.id_user')
                    ->get();
    }
    
    private function getAuthenticatedUser($groupId) {
        $authenticated = auth()->user();
        $idMatchday = $this->getMatchdayId();
        if ($authenticated) {
            $username = $authenticated->username;

            $users = User::where(function ($query) {
                            $query->where('status', 1)->orWhere('status', 0);
                        })
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
                        ->where('u1.id_matchday', '=', $idMatchday)     
                        ->select('users.username', 'users.name', 'u1.points_total', 'u1.points_matchday')
                        ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')
                        ->leftJoin('user_data_flow AS u2', function($join) use($idMatchday) {
                            $join->on('users.id', '=', 'u2.id_user');
                            $join->where('u2.id_matchday', '=', $idMatchday - 1);
                        })
                        ->orderBy('u1.position')
                        ->get(); 
        }
        $user['position'] = $position + 1;
        return $user;
    }
    
    //maybe later
    /*public function search(Request $request) {
        $idMatchday = $this->getMatchdayId()[0];
        $search = $request->input('text');

        if (is_null($search) || strcmp($search, '') == 0) {
            $data = $this->index()->render();
            return response()->json(array('success' => true, 'search' => $search, 'html' => $data));
        }

        $participants = User::whereHas('groups', function($query) use($groupId) {
            $query->where('groups.id', '=', $groupId);
                    })
                    ->where(function ($query) {
                        $query->where('users.status', 1)->orWhere('users.status', 0);
                    })
                    ->where('users.username', 'like', '%' . $search . '%')
                    ->where('u1.id_matchday', '=', $idMatchday)
                    ->select('users.username', 'users.name', 'u1.points_total', 'u1.points_matchday')
                    ->join('user_data_flow AS u1', 'users.id', '=', 'u1.id_user')    
                    ->orderBy('u1.position')
                    ->paginate(5)
                    ->setPath('group/{id}');
        

        $user = $this->getAuthenticatedUser();

        $data = [
            'participants' => $participants,
            'user' => $user,
        ];

        $returnHTML = view('groups.table')->with('data', $data)->render();
        return response()->json(array('success' => true, 'search' => $search, 'html' => $returnHTML));
    }*/
    
    private function getMatchdayId() {
        $id = Matchday::where('finished', 1)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->pluck('id');
        return count($id) == 0 ? 0 : $id[0];
    }

}
