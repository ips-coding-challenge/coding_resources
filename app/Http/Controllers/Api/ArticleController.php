<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	public function index(Request $request){

		// die();

		if($request->categories){
			$articles = Article::filters('articles', 'App\Models\Article', $request)
				->orderBy('id', 'desc')
				->paginate(config('app.api_per_page'));

			// $newArticles = sortByCategoriesMatchCount($articles, $request->categories, config('app.api_per_page'));

			return response()->json($articles, 200, [], JSON_NUMERIC_CHECK);

		}else{
			$articles = Article::customLatest('articles', $request)->paginate(config('app.api_per_page'));

			return response()->json($articles, 200, [], JSON_NUMERIC_CHECK);
		}

		

	}

}
