<?php

namespace App\Models;

use App\Models\DeletableTrait;
use App\Models\FiltersTrait;
use App\Models\Langue;
use App\Models\ModelHelperTrait;
use App\Models\TutoPart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tuto extends Model
{
    // use Searchable;
    use HasSlug, ModelHelperTrait, DeletableTrait, BasicQueryTrait;

    protected $guarded = [];

    public function tutoParts()
    {
        return $this->hasMany(TutoPart::class);
    }

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

    /**
     * I dont use the trait to get tutoParts too for this model
     * @param  [type] $query      [description]
     * @param  [type] $table      [description]
     * @param  [type] $type       [description]
     * @param  array  $categories [description]
     * @return [type]             [description]
     */
    public static function scopeFilters($query, $request)
    {
        $newQuery = $query->with(['categories', 'langue', 'tutoParts'])
            ->join('taggables', 'taggables.taggable_id', '=', "tutos.id")
            ->where('taggables.taggable_type', 'App\Models\Tuto')
            ->whereIn('taggables.category_id', $request->categories)
            ->where('is_valid', 1)
            ->select("tutos.*");

        if ($request->has('langue')) {
            $newQuery->where('langue_id', (int)$request->langue);
        }

        $newQuery->groupBy("tutos.id")
            ->withCount('categories')
            ->orderBy('updated_at', 'desc');

        return $newQuery;

    }


    /** Method handling add / delete tuto parts */
    public function saveTutoParts(array $parts)
    {

        // dd($parts);
        $ids = [];
        foreach ($parts as $part) {
            $part['youtube_id'] = convertYoutubeLinkToId($part['youtube_id']);
            $ids[] = $this->tutoParts()->updateOrCreate(['youtube_id' => $part['youtube_id']], $part)->id;
        }

        $toDelete = TutoPart::where('tuto_id', $this->id)->whereNotIn('id', $ids)->get();

        if (count($toDelete) > 0) {
            $idsToDelete = $toDelete->pluck('id');
            TutoPart::destroy($idsToDelete);
        }

    }
}
