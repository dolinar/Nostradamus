<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $table = 'prediction';

    public function fixture() {
        return $this->belongsTo('App\Fixture', 'id_fixture');
    }

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function predictionResults() {
        return $this->hasOne('App\PredictionResult', 'id_prediction');
    }
}
