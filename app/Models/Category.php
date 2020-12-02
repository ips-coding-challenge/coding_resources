<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function conferences(){
        return $this->morphedByMany('App\Models\Conference', 'taggable');
    }

    public function articles(){
    	return $this->morphedByMany('App\Models\Article', 'taggable');
    }

    public function tutos(){
        return $this->morphedByMany('App\Models\Tuto', 'taggable');
    }
}
