<?php

namespace App\Models;

use App\Models\FiltersTrait;
use App\Models\ModelHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Conference extends Model
{

    // use Searchable;
    use HasSlug, ModelHelperTrait, DeletableTrait, FiltersTrait, BasicQueryTrait;

    protected $guarded = [];

    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'taggable');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function getSlugOptions()
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

}
