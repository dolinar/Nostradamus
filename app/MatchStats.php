<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchStats extends Model
{
    protected $table = 'match_stats';
    protected $primaryKey = 'id_match';

    public function fixture() {
        return $this->belongsTo('App\Fixture', 'id_match', 'id_match');
    }
}
