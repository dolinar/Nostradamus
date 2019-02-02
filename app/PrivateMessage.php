<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $table = 'private_messages';

    protected $fillable = array('opened');

    public function sender() {
        return $this->belongsTo('App\User', 'id_sender');
    }

    public function receiver() {
        return $this->belongsTo('App\User', 'id_receiver');
    }
}
