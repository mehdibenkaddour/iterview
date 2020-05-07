<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content','correct','question_id',
    ];
    public function question(){
        return $this->belongsTo('App\Models\Question');
    }
}
