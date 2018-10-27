<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    //

    public function matchday() {
        return $this->belongsTo('App\Matchday', 'id', 'id_matchday');
    }
}
