<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class ConferenceController extends Controller
{
	public function index(Request $request){ 

		// return response()->json("", 500);
		if($request->categories){
			$conferences = Conference::filters('conferences', 'App\Models\Conference', $request)
				->orderBy('published_at', 'desc')	
				->paginate(config('app.api_per_page'));

			// $newConf = sortByCategoriesMatchCount($conferences, $request->categories, config('app.api_per_page'));

			return response()->json($conferences, 200, [], JSON_NUMERIC_CHECK);

		}else{
			$conferences = Conference::customLatest('conferences', $request)->paginate(config('app.api_per_page'));

			return response()->json($conferences, 200, [], JSON_NUMERIC_CHECK);
		}

	}

}
