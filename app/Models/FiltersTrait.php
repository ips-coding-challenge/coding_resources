<?php 

namespace App\Models;

use Illuminate\Support\Facades\DB;

trait FiltersTrait{

	/**
	 * Method to fetch data with categories filter
	 * @param  [type] $query      QueryBuilder
	 * @param  [type] $table      Table where we wants results "eg: conferences"
	 * @param  [type] $type       Taggable Type "eg: App\Models\Conference"
	 * @param  array  $categories Categories to filter through
	 * @return [type] QueryBuilder
	 */
	public static function scopeFilters($query, $table, $type, $request){
	        $newQuery = $query->with(['categories', 'langue'])	            
	            ->join('taggables', 'taggables.taggable_id', '=', "{$table}.id")
	            ->where('taggables.taggable_type', $type)	            
	            ->whereIn('taggables.category_id', $request->categories)
	            ->where('is_valid', 1)
	            ->select("{$table}.*");

            if($request->has('langue')){
            	$newQuery->where('langue_id', (int) $request->langue);
            }

            $newQuery         
	            ->groupBy("{$table}.id")
	            ->withCount('categories')
	            ->orderBy('updated_at', 'desc');

            return $newQuery;

	}

}