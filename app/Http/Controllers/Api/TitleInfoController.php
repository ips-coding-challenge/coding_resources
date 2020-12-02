<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Book;
use Illuminate\Http\Request;

class TitleInfoController extends Controller
{
    
    public function checkTitle(Request $request){

    	if(!$request->type && !$request->title) {
    		return;
    	}

    	if($request->type === "article"){
    		$article = Article::where("title", "=", trim($request->title))->first();
    		if($article){
	    		return response()->json([
	    			'error' => "There is an article with this title : {$article->title}" 
	    		], 422);
    		}
    	}

    	if($request->type === "book"){
    		$book = Book::where("title", "=", trim($request->title))->first();
    		if($book){
    			return response()->json([
    				'error' => "There is a book with this title : {$book->title}" 
    			], 422);
    		}
    	}

    	return response()->json([], 200);

    }

}
