<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){

    	$categories = Category::orderBy('name', 'ASC')->get();

    	return response()->json(["data" => $categories], 200, [], JSON_NUMERIC_CHECK);

    }
}
