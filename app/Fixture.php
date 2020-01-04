<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Fixture extends Model
{

    protected $table = 'fixtures';
    protected $fillable = ['home_score', 'away_score'];
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

    public function usersPrediction() {
        return $this->hasOne('App\Prediction', 'id_fixture')->where('id_user', Auth::user()->id);
    }
}
