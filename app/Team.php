<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    public function overallPredictions() {
        return $this->hasMany('App\OverallPrediction', 'id_team');
    }

    public function fixtureHome() {
        return $this->hasMany('App\Fixture', 'home_team');
    }

    public function fixtureAway() {
        return $this->hasMany('App\Fixture', 'away_team');
    }

    public function fixtures() {
        return $this->fixtureHome->merge($this->fixtureAway);
    }
}

