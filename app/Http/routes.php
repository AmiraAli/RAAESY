<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

#Route::get('search/autocomplete', 'ArticlesController@autocomplete');




Route::resource('/categories','CategoriesController');

Route::resource('/sections','SectionsController');


Route::get('users/search','UsersController@search');
Route::post('users/ajaxsearch','UsersController@ajaxsearch');
Route::get('users/changepassword/{id}','UsersController@changepassword');
Route::post('users/changepassprocess','UsersController@changepassprocess');


Route::resource('/users','UsersController');

Route::get('users/destroy/{id}','UsersController@destroy');
Route::post('users/get_user_types','UsersController@get_user_types');
Route::post('users/autocomplete','UsersController@autocomplete');


Route::post('articles/autocomplete','ArticlesController@autocomplete');
Route::post('articles/getTags', 'ArticlesController@getTags');
Route::post('articles/search', 'ArticlesController@search');
Route::get('articles/home', 'ArticlesController@home');

Route::post('tickets/searchTicket', 'TicketsController@searchTicket');
Route::post('tickets/sortTicket', 'TicketsController@sortTicket');
Route::post('tickets/relatedTag', 'TicketsController@relatedTag');
Route::resource('/tickets','TicketsController');

Route::post('/tickets/updatestatus','TicketsController@updatestatus');
Route::post('/tickets/takeover','TicketsController@takeover');
Route::post('/tickets/save','TicketsController@Save');
Route::post('tickets/addSubject', 'TicketsController@addSubject');
Route::post('tickets/getTags', 'TicketsController@getTags');
Route::post('/subjects/all/', 'TicketsController@SearchAllSubject');
Route::post('/tickets/all/subjects', 'TicketsController@TicketAllSubject');

Route::post('/tickets/advancedsearch', 'TicketsController@AdvancedSearch');

Route::post('/tickets/spamTicket', 'TicketsController@spamTicket');
Route::post('/tickets/unSpamTicket', 'TicketsController@unSpamTicket');

Route::post('/tickets/closeTicket', 'TicketsController@closeTicket');
Route::post('/tickets/openTicket', 'TicketsController@openTicket');
Route::post('tickets/addTag', 'TicketsController@addTag');




Route::resource('tickets.comments', 'CommentsController');

Route::resource('/articles','ArticlesController');

Route::post('assets/searchAssets', 'AssetsController@searchAssets');

Route::resource('/assets', 'AssetsController');
Route::post('/assets/addasset', 'AssetsController@AddAssets');
Route::post('/assets/saveassets/', 'AssetsController@SaveAssets');
Route::post('assets/addType', 'AssetsController@addType');

Route::get('/reports/logs', 'ReportsController@logs');
Route::get('/reports/disthour', 'ReportsController@distHour');
Route::get('/reports/summary', 'ReportsController@SummaryCategories');

Route::post('/reports/disthourajax', 'ReportsController@ajaxdistHour');

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



