<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'label', 'topic_id',
    ];
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }
    public function questions(){
        return $this->hasMany('App\Models\Question');
    }
}
