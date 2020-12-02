<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class YoutubeInfoController extends Controller
{

	private $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	public function infos()
	{

		$youtubeId = convertYoutubeLinkToId(request('url'));

		if ($youtubeId === null) return response()->json(['error' => 'wrong youtube link'], 422);

		$infos = getYoutubeInfo($youtubeId);

		return response()->json($infos, 200, [], JSON_NUMERIC_CHECK);
	}

	public function allPartsFromPlaylist($playlistId)
	{

		$allParts = getAllPartsFromPlaylist($playlistId);

		return response()->json($allParts, 200, [], JSON_NUMERIC_CHECK);
	}

	public function videoDuration($videoId)
	{
		$apiKey = env('YOUTUBE_API_KEY');
		$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id={$videoId}&key={$apiKey}";
		try {
			$response = $this->client->request('GET', $url);
		} catch (RequestException $e) {
			die($e->getMessage());
		}

		$data = \GuzzleHttp\json_decode($response->getBody());

		$duration = $data->items[0]->contentDetails->duration;

		return response()->json(convertDuration($duration), 200, [], JSON_NUMERIC_CHECK);
	}
}
