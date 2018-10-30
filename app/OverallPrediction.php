<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverallPrediction extends Model
{
    protected $table = 'overall_predictions';

    public function team() {
        return $this->belongsTo('App\Team', 'id_team');
    }

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }

}
