<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $fillable = [
        'username', 'name', 'email', 'password', 'status',
    ];

    // used for checking if user is admin
    public function getStatus() {
        return $this->status;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function overallPrediction() {
        return $this->hasOne('App\OverallPrediction', 'id_user');
    }

    public function predictions() {
        return $this->hasMany('App\Prediction', 'id_user');
    }

    public function groups() {
        return $this->belongsToMany('App\Group', 'user_group', 'id_user', 'id_group');
    }
}
