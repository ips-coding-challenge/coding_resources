<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     var_dump($query->sql);
//     var_dump($query->bindings);
//     var_dump($query->time);
// });
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** get youtube info needed */
Route::get('youtube_info', 'YoutubeInfoController@infos');
Route::get('playlist_parts/{playlistId}', 'YoutubeInfoController@allPartsFromPlaylist');
Route::get('video_duration/{videoId}', 'YoutubeInfoController@videoDuration');

/** get amazon product info */
Route::get('amazon/{productId}', 'AmazonProductController@infos');

/** Check title */
Route::get('checkTitle', 'TitleInfoController@checkTitle');

Route::post('propositions', 'PropositionController@store');

Route::get('conferences', 'ConferenceController@index');
Route::get('articles', 'ArticleController@index');

Route::get('tutos', 'TutoController@index');
Route::get('tutos/{id}', 'TutoController@show');

Route::get('books', 'BookController@index');

Route::get('categories', 'CategoryController@index');

Route::get('search', 'SearchController@index');
Route::get('suggestions', 'SearchController@suggestions');