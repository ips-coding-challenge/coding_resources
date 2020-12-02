<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Book;
use App\Models\Conference;
use App\Models\Tuto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PropositionController extends Controller
{
    public function store(Request $request){

        $linkRule = ['required'];
        if(request('type') === 'conference'){

            $custom = ['youtube_link','uniqueInConferences'];
            $linkRule = array_merge($linkRule, $custom);

        }else if(request('type') === 'tuto'){

            $custom = ['youtube_link', 'uniqueInTutoAndTutoPart'];
            $linkRule = array_merge($linkRule, $custom);

        }else if(request('type') === 'article'){
            $custom = ['url', 'unique:articles,url'];
            $linkRule = array_merge($linkRule, $custom);

        }else {
            $custom = ['url', 'unique:books,link'];
            $linkRule = array_merge($linkRule, $custom);
        }

        $this->validate($request, [
            'title' => 'required',
            'link' => $linkRule,
            'type' => 'required|in:conference,tuto,article,book'
        ]);

        return $this->saveProposition(request('type'));

    }

    private function saveProposition($type){
        switch ($type){
            case "conference":
                return $this->createConferenceOrTuto('conference');
            case "tuto":
                return $this->createConferenceOrTuto('tuto');
            case "article":
                return $this->createArticle();
            case "book" : 
                return $this->createBook();
        }
    }

    private function createConferenceOrTuto($type){

        $youtubeId = convertYoutubeLinkToId(request('link'));

        if($youtubeId == null) return response()->json(['error' => 'youtube id is not valid'], 422);

        $data = [
            'title' => request('title'),
            'youtube_id' => $youtubeId
        ];

        try{

            switch ($type){
                case 'conference' : Conference::create($data);
                    break;
                case 'tuto' : Tuto::create($data);
                    break;
            }

            return response()->json([], 201);

        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    
    private function createArticle(){
        try{

            Article::create([
                'title' => request('title'),
                'url' => request('link')
            ]);

            return response()->json([], 201);

        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    private function createBook(){
        try{

            Book::create([
                'title' => request('title'),
                'link' => request('link')
            ]);

            return response()->json([], 201);

        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
