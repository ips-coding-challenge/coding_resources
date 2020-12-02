<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Book;
use App\Models\Tuto;
use App\Models\Article;
use App\Models\Conference;
use App\Models\PrivateMessage;
use Illuminate\Support\Facades\Cache;

class PropositionCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Cache::has('proposition_count')){

            $propCount = Cache::get('proposition_count');

        }else{

            $conferencesCount = Conference::where('is_valid', 0)->count();
            $articlesCount = Article::where('is_valid', 0)->count();
            $tutosCount = Tuto::where('is_valid', 0)->count();
            $booksCount = Book::where('is_valid', 0)->count();
            $messagesCount = PrivateMessage::where('read', 0)->count();

            $propCount = [
                'conferencesCount' => $conferencesCount,
                'articlesCount' => $articlesCount,
                'tutosCount' => $tutosCount,
                'booksCount' => $booksCount,
                'messagesCount' => $messagesCount
            ];

            Cache::put('proposition_count', $propCount, 10);

        }

        $request->attributes->add($propCount);

        return $next($request);
    }
}
