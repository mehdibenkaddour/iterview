<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content','image','image','type','level','section_id',
    ];
    public function section(){
        return $this->belongsTo('App\Models\Section');
    }
    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }
}
