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

Route::resource('/categories','CategoriesController');
Route::resource('/sections','SectionsController');

Route::resource('/users','UsersController');
Route::get('users/destroy/{id}','UsersController@destroy');

Route::resource('/tickets','TicketsController');

Route::resource('tickets.comments', 'CommentsController');

Route::resource('/articles','ArticlesController');


Route::get('/assets/search', 'AssetsController@search');
Route::post('assets/searchAssets', 'AssetsController@searchAssets');
Route::resource('/assets', 'AssetsController');


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
