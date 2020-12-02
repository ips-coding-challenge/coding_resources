<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
	public function index(Request $request){

		if($request->categories){
			$books = Book::filters('books', 'App\Models\Book', $request)
				->orderBy('updated_at', 'desc')
				->paginate(config('app.api_per_page'));

			// $newBooks = sortByCategoriesMatchCount($books, $request->categories, config('app.api_per_page'));

			return response()->json($books, 200, [], JSON_NUMERIC_CHECK);
		}else{
			$books = Book::customLatest('books', $request)->paginate(config('app.api_per_page'));

			return response()->json($books, 200, [], JSON_NUMERIC_CHECK);
		}

		

	}
}
