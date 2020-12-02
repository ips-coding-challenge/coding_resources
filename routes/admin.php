<?php

// \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     var_dump($query->sql, $query->bindings);
//     var_dump($query->bindings);
//     var_dump($query->time);
// });

//Route::get('/');
//
//

Route::get('/', 'AdminController@index');

//Propositions
Route::get('/proposition/create', 'PropositionController@create');
Route::post('/proposition', 'PropositionController@store');

//Conferences
Route::get('/conference/propositions', 'ConferenceController@propositions');
Route::resource('conference', 'ConferenceController');

//Articles
Route::get('/article/propositions', 'ArticleController@propositions');
Route::resource('article', 'ArticleController');

//Tutos
Route::get('/tuto/propositions', 'TutoController@propositions');
Route::resource('tuto', 'TutoController', ['except' => 
		['create', 'store']
	]);

//Books
Route::get('/book/propositions', 'BookController@propositions');
Route::resource('book', 'BookController');

//Categories
Route::resource('category', 'CategoryController');

//Private Message
Route::get('/message', 'PrivateMessageController@index');
Route::get('/message/{message}', 'PrivateMessageController@show');
Route::delete('/message/{message}', 'PrivateMessageController@destroy');

//Issues
Route::get('/issue', 'IssueController@index');

Route::get('/deleted-youtube-videos', 'IssueController@deletedYoutubeVideos');
Route::get('/youtube-issues', 'IssueController@youtubeIssues');

