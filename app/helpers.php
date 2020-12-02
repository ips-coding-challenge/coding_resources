<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

function convertYoutubeLinkToId($url)
{
    $media_url = "";
    if (preg_match('#(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})?#', $url, $videoid)) {
        if (isset($videoid[1]) and strlen($videoid[1])) {
            $media_url = 'youtube:_:' . $videoid[1];
        }
    }

    if (!strlen($media_url)) {

        return null;

    } else {
        $idyoutube = explode(':_:', $media_url);
        $idyoutube = trim($idyoutube[1]);
        return $idyoutube;
    }
}

function getYoutubeInfo($id)
{
    $youtube_api_key = env('YOUTUBE_API_KEY');
    $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id={$id}&key={$youtube_api_key}";
    // dd($url);
    $client = new Client();
    try {
        $response = $client->request('GET', $url);
    } catch (RequestException $e) {
        die($e->getMessage());
    }

    $data = \GuzzleHttp\json_decode($response->getBody());
    if (!empty($data->items)) {
        try {
            $description = $data->items[0]->snippet->description;
            $description = linkify($description, 'http');
            $title = $data->items[0]->snippet->title;
            $channelName = $data->items[0]->snippet->channelTitle;
            $duration = $data->items[0]->contentDetails->duration;
            $published_at = $data->items[0]->snippet->publishedAt;

            $all = [
                'title' => $title,
                'published_at' => $published_at,
                'description' => $description,
                'channel_name' => $channelName,
                'duration' => convertDuration($duration)
            ];
            return $all;
        } catch (\Exception $e) {
            die($e->getMessage());
        }

    }
}

function getAllPartsFromPlaylist($playlistId)
{
    $youtube_api_key = env('YOUTUBE_API_KEY');
    $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=50&playlistId={$playlistId}&key={$youtube_api_key}";

    $client = new Client();

    try {
        $response = $client->request('GET', $url);
    } catch (RequestException $e) {
        die($e->getMessage());
    }

    $data = \GuzzleHttp\json_decode($response->getBody());

    $items = $data->items;

    $finalItems = [];

    foreach ($items as $item) {
        $finalItems[] = ["title" => $item->snippet->title, "part_number" => (int)($item->snippet->position) + 1, "youtube_id" => $item->contentDetails->videoId];
    }

    return $finalItems;
}

function getVideoDuration($videoId)
{

    $youtube_api_key = env('YOUTUBE_API_KEY');

    $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id={$videoId}&key={$youtube_api_key}";

    $client = new Client();

    try {
        $response = $client->request('GET', $url);
    } catch (RequestException $e) {
        die($e->getMessage());
    }

    $data = \GuzzleHttp\json_decode($response->getBody());

    $duration = $data->items[0]->contentDetails->duration;

    return convertDuration($duration);
}

function convertDuration($duration)
{
    $formated_stamp = str_replace(array("PT", "M", "S"), array("", ":", ""), $duration);

    $exploded_string = explode(":", $formated_stamp);

    if (preg_match("/H/", $exploded_string[0])) {
        $replaced = str_replace("H", ":", $exploded_string[0]);
        $explodedHourMin = explode(":", $replaced);
        $hour = $explodedHourMin[0];
        $minutes = (int)$explodedHourMin[1] < 10 ? "0" . $explodedHourMin[1] : $explodedHourMin[1];
    } else {
        $replaced = $exploded_string[0];
    }

    if (!isset($exploded_string[1])) {
        return '00:' . $exploded_string[0];
    }

    if (isset($hour) && isset($minutes)) {
        return $hour . ":" . $minutes . ":" . sprintf("%02d", $exploded_string[1]);
    } else {
        return sprintf("%02s", $replaced) . ":" . sprintf("%02d", $exploded_string[1]);
    }

}

// function convertLinkInDescription($description)
// {
//     $pattern = '`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)`';
//     //Fonction permettant de raccourcir les longues URL lors du remplacement dans la fonction preg_replace_callback()
//     $callback_function = function($matches) {
//         $link_displayed = (strlen($matches[0]) > 20) ? substr( $matches[0], 0, 20).'[&hellip;]'.substr($matches[0], -10) : $matches[0];
//         return $test;
//     };
    
//     return preg_replace_callback($pattern, $callback_function, $description);
// }

function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
{
        // Link attributes
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr = ' ' . $key . '="' . htmlentities($val) . '"';
    }

    $links = array();
        
        // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
        return '<' . array_push($links, $match[1]) . '>';
    }, $value);
        
        // Extract text links for each protocol
    foreach ((array)$protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https':
                $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    if ($match[1]) $protocol = $match[1];
                    $link = $match[2] ? : $match[3];
                    return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                }, $value);
                break;
            case 'mail':
                $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
            case 'twitter':
                $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\">{$match[0]}</a>") . '>';
                }, $value);
                break;
            default:
                $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
        }
    }
        
        // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
        return $links[$match[1] - 1];
    }, $value);
}

function paginate($items, $perPage = 15, $page = null, $options = [])
{
    $page = $page ? : (Paginator::resolveCurrentPage() ? : 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    //Changed forPage() to forPage()->values()->all() to have same format for all pages
    return new LengthAwarePaginator($items->forPage($page, $perPage)->values()->all(), $items->count(), $perPage, $page, $options);
}

function sortByCategoriesCount(Collection $collection, $perPage)
{
    $sorted = $collection->sortByDesc(function ($item) {
        return count($item->categories);
    });
    return paginate($sorted, $perPage);
}

function sortByCategoriesMatchCount(Collection $collection, $categories, $perPage)
{
    $sorted = $collection->sortByDesc(function ($item) use ($categories) {
        $cat = collect($item->categories);
        $test = $cat->whereIn("id", $categories);
        return count($test);
    });
    return paginate($sorted, $perPage);
}