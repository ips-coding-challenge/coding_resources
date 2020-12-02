<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Tuto;
use GuzzleHttp\Client;
use App\Models\Article;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
	public function index(){

		$conferencesIssue = Conference::where("is_valid", 1)->whereRaw("
			(SELECT count(*) from taggables WHERE taggables.taggable_id = conferences.id AND taggables.taggable_type = 'App\\\\Models\\\\Conference') = 0")
		->get();
		$articlesIssue = Article::where("is_valid", 1)->whereRaw("
			(SELECT count(*) from taggables WHERE taggables.taggable_id = articles.id AND taggables.taggable_type = 'App\\\\Models\\\\Article') = 0")
		->get();
		$tutosIssue = Tuto::where("is_valid", 1)->whereRaw("
			(SELECT count(*) from taggables WHERE taggables.taggable_id = tutos.id AND taggables.taggable_type = 'App\\\\Models\\\\Tuto') = 0")
		->get();
		$booksIssue = Book::where("is_valid", 1)->whereRaw("
			(SELECT count(*) from taggables WHERE taggables.taggable_id = books.id AND taggables.taggable_type = 'App\\\\Models\\\\Book') = 0")
		->get();


		return view('admin.issues.index', compact('conferencesIssue', 'articlesIssue', 'tutosIssue', 'booksIssue'));
	}

	/** index of youtube deleted videos */
	public function deletedYoutubeVideos() {
		return view('admin.issues.youtube');
	}

	public function youtubeIssues(Request $request){

		$client = new Client();

		$conferences = Conference::where("channel_name", $request->channel)->get();
		$deletedConferences = $conferences->filter(function($conf) use ($client){

			$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id={$conf->youtube_id}&key=AIzaSyDGo5E2hMOmCbgkRqFExpiN9LtcN5DDtkA";
			
			try{
				$response = $client->request('GET', $url);
			}catch(RequestException $e){
				die($e->getMessage());
			}
			$data = \GuzzleHttp\json_decode($response->getBody());

			return count($data->items) === 0;
		});

		return response()->json($deletedConferences->values(), 200, [], JSON_NUMERIC_CHECK);
	
	}
}
