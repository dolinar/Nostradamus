<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FixtureChatroomMessage extends Model
{
    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function fixture() {
        return $this->belongsTo('App\Fixture', 'id_fixture');
    }
}
