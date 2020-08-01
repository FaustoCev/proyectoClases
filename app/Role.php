<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $hidden = [
        'pivot',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
