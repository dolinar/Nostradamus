<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matchday extends Model
{
    protected $table = 'matchdays';

    public function fixtures() {
        return $this->hasMany('App\Fixture', 'id_matchday');
    }
}

