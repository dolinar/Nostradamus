<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PredictionResult extends Model
{
    protected $table = 'prediction_result';
    
    public function prediction() {
        return $this->belongsTo('App\Prediction', 'id_prediction');
    }
}
