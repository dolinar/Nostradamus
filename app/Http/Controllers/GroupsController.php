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
            'info' => $info,

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
            if ($position + 1 > 5) {
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
        
        $users = User::pluck('username', 'id');



        $data = [
            'group' => $group,
            'users' => $users
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
            return redirect('/')->with('success', 'Uspešno ste bili dodani v skupino!'); 
        } else {
            return redirect('/')->with('success', 'Povabilo za skupino zavrnjeno.'); 
        }

    }

    public function sendInvitation(Request $request) {
        $idGroup = $request->group_id;
        $idUser = $request->user_id_select;
        $adminCheckbox = ($request->user_checkbox) ? 1 : 0;

        if (count(Group::find($idGroup)->users()->where('users.id', '=', $idUser)->get()) > 0) {
            return redirect('/groups/' . $idGroup)->with('error', 'Uporabnik je že v skupini!'); 
        }

        $invitation =  DB::table('group_invitations')
                                ->select('id')
                                ->where([
                                    ['id_group', '=', $idGroup],
                                    ['id_user', '=', $idUser]
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
}
