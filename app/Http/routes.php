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

Route::resource('/users','UsersController');
Route::get('users/destroy/{id}','UsersController@destroy');
Route::post('users/get_user_types','UsersController@get_user_types');
Route::post('users/autocomplete','UsersController@autocomplete');
Route::get('users/search','UsersController@search');



Route::post('articles/autocomplete','ArticlesController@autocomplete');




Route::post('tickets/sortTicket', 'TicketsController@sortTicket');
Route::resource('/tickets','TicketsController');

Route::post('/tickets/updatestatus','TicketsController@updatestatus');
Route::post('/tickets/takeover','TicketsController@takeover');
Route::post('/tickets/save','TicketsController@Save');
Route::post('tickets/addSubject', 'TicketsController@addSubject');
Route::post('tickets/getTags', 'TicketsController@getTags');



Route::resource('tickets.comments', 'CommentsController');

Route::resource('/articles','ArticlesController');

Route::post('assets/searchAssets', 'AssetsController@searchAssets');

Route::resource('/assets', 'AssetsController');
Route::post('/assets/addasset', 'AssetsController@AddAssets');
Route::post('/assets/saveassets/', 'AssetsController@SaveAssets');
Route::post('assets/addType', 'AssetsController@addType');



Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
