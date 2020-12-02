<?php 

namespace App\Models;

use App\Models\Article;
use App\Models\Book;
use App\Models\Category;
use App\Models\Conference;
use App\Models\Tuto;
use Illuminate\Support\Facades\DB;

trait ModelHelperTrait
{

    public function saveCategories($categories)
    {

        $categories = explode(",", rtrim($categories, ","));
        //Trim + lower for the categories
        $cleaned = array_map(function ($cat) {
            return trim($cat);
        }, $categories);

        //DB::raw used to check on lowercase
        $existingCategories = Category::whereIn('name', $cleaned)->get();

        //Need to lowercase cat name from the database too
//        $transformed = $existingCategories->map(function($cat){
//            return trim(strtolower($cat->name));
//        });

        //Check the difference between the 2 arrays
        $newCategories = array_diff($cleaned, $existingCategories->pluck('name')->toArray());

        $addedCategories = [];
        foreach ($newCategories as $cat) {
            $addedCategories[] = Category::create(['name' => $cat])->id;
        }

        $merged = array_merge($existingCategories->pluck('id')->toArray(), $addedCategories);

        $this->categories()->sync($merged);
    }

    public function convertCategoriesToString()
    {
        return implode(',', $this->categories()->get()->pluck('name')->toArray());
    }

    public static function scopePublished($query)
    {
        return $query->where('is_valid', 1);
    }

    public static function scopeForSearch($query, $request, $type = null)
    {

        $with = ['categories', 'langue'];

        if ($type != null) {
            $with[] = 'tutoParts';
        }

        $lowerRequest = strtolower($request->q);

        $results = $query->with($with)->where('is_valid', 1)->whereRaw("LOWER(title) like ?", ["%{$lowerRequest}%"])->get();

        $results->map(function ($item) {
            if ($item instanceof Conference) {

                $item['type'] = "conference";

            } else if ($item instanceof Article) {

                $item['type'] = "article";

            } else if ($item instanceof Tuto) {

                $item['type'] = "tuto";

            } else if ($item instanceof Book) {

                $item['type'] = "book";

            } else {
                throw new \Exception("Item is a weird object ;)");
            }
        });

        return $results;
    }
}