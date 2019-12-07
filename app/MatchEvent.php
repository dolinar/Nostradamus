<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    protected $table = 'match_events';

    public function fixture() {
        return $this->belongsTo('App\Fixture', 'id_match', 'id_match');
    }
}
