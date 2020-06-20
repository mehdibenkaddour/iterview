<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }
}
