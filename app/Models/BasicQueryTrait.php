<?php 

namespace App\Models;

trait BasicQueryTrait{
	public static function scopeCustomLatest($query, $table, $request){

		$with = ['categories', 'langue'];
		if($table === 'tutos'){
			$with[] = 'tutoParts';
		}

		$newQuery = $query->with($with)
			->published();

		// if($table == "tutos" || $table == "conferences"){
		// 	$newQuery->orderBy('published_at', 'desc');
		// }
		
		$newQuery->orderBy('updated_at', 'desc');

		if($request->langue){
			$newQuery->where('langue_id', (int) $request->langue);
		}

		return $newQuery;
	}
}