<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function users() {
        return $this->belongsToMany('App\User', 'user_group', 'id_group', 'id_user');
    }

}
