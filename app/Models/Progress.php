<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = [
        'user_id', 'section_id','score',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function section(){
        return $this->belongsTo('App\Models\Section');
    }
}
