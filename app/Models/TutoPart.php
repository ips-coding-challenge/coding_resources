<?php

namespace App\Models;

use App\Models\Tuto;
use Illuminate\Database\Eloquent\Model;

class TutoPart extends Model
{
    protected $guarded = [];

    public function tuto(){
    	return $this->belongsTo(Tuto::class);
    }
}
