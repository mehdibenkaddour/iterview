<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'image',
    ];
    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }
}
