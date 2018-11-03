<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{

    protected $table = 'fixtures';

    public function matchday() {
        return $this->belongsTo('App\Matchday', 'id_matchday');
    }

    public function prediction() {
        return $this->hasMany('App\Prediction', 'id_fixture');
    }

    public function teamHome() {
        return $this->belongsTo('App\Team', 'home_team');
    }

    public function teamAway() {
        return $this->belongsTo('App\Team', 'away_team');
    }

    public function teams() {
        return $this->teamHome->merge($this->teamAway);
    }
}
