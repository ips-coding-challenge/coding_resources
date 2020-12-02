<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Book;
use App\Models\Conference;
use App\Models\Proposition;
use App\Models\Rejected;
use App\Models\Tuto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropositionController extends Controller
{

    public function create(){

        $choices = ['conference', 'tuto', 'article', 'book'];

        return view('admin.propositions.create', compact('choices'));
    }

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

        Cache::forget('proposition_count');
        
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

        if($youtubeId == null) return back()->with('danger', 'Youtube id not valid!');

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

            return back()->with('added', 'Proposition added');

        }catch(QueryException $e){
            return back()->with('danger', 'An Error Occured = ' . $e->getMessage());
        }
    }

    
    private function createArticle(){
        try{

            Article::create([
                'title' => request('title'),
                'url' => request('link')
            ]);

            return back()->with('added', 'Proposition added');

        }catch(QueryException $e){
            return back()->with('danger', 'An Error Occured = ' . $e->getMessage());
        }
    }

    private function createBook(){

        try{

            Book::create([
                'title' => request('title'),
                'link' => request('link')
            ]);

            return back()->with('added', 'Proposition added');

        }catch(QueryException $e){
            return back()->with('danger', 'An Error Occured = ' . $e->getMessage());
        }
    }

}
