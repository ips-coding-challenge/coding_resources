<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Book;
use App\Models\Conference;
use App\Models\Tuto;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $allItems = new Collection();
        $allItems = $allItems->merge(Conference::forSearch($request));
        $allItems = $allItems->merge(Article::forSearch($request));
        $allItems = $allItems->merge(Tuto::forSearch($request, 'tuto'));
        $allItems = $allItems->merge(Book::forSearch($request));

        $sorted = $allItems->sortByDesc('updated_at');
        $sorted = paginate($sorted->values()->all(), config('app.api_per_page'));

        return response()->json($sorted, 200, [], JSON_NUMERIC_CHECK);

    }

    public function suggestions(Request $request)
    {

        $allItems = new Collection();

        $lowerRequest = strtolower($request->q);

        $conferences = Conference::select('title')->whereRaw("LOWER(title) like ?", ["%{$lowerRequest}%"])->limit(3)->get();
        $conferences->map(function ($item) {
            $item['type'] = "conference";
        });
        $articles = Article::select('title')->whereRaw("LOWER(title) like ?", ["%{$lowerRequest}%"])->limit(3)->get();
        $articles->map(function ($item) {
            $item['type'] = "article";
        });
        $tutos = Tuto::select('title')->whereRaw("LOWER(title) like ?", ["%{$lowerRequest}%"])->limit(3)->get();
        $tutos->map(function ($item) {
            $item['type'] = "tuto";
        });
        $books = Book::select('title')->whereRaw("LOWER(title) like ?", ["%{$lowerRequest}%"])->limit(3)->get();
        $books->map(function ($item) {
            $item['type'] = "book";
        });

        $allItems = $allItems->merge($conferences);
        $allItems = $allItems->merge($articles);
        $allItems = $allItems->merge($tutos);
        $allItems = $allItems->merge($books);

        return response()->json(['data' => $allItems], 200);

    }
}
