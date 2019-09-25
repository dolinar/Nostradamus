<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomMessage extends Model
{
    protected $table = 'chatroom_messages';

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function group() {
        return $this->belongsTo('App\Group', 'id_group');
    }
}
