<?php
use App\Ticket;
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

Route::get('/all-tweets-csv', function() {
    $tweets = Ticket::all();

    // the csv file with the first row
    $output = implode(",", array('id', 'description', 'priority', 'deadline'))."\n";

    foreach ($tweets as $row) {
        // iterate over each tweet and add it to the csv
        $output .=  implode(",", array($row['id'], $row['description'], $row['priority'], $row['deadline']))."\n"; // append each row
    }

    // headers used to make the file "downloadable", we set them manually
    // since we can't use Laravel's Response::download() function
    $headers = array(
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="tweets.csv"',
        );

    // our response, this will be equivalent to your download() but
    // without using a local file
    return Response::make(rtrim($output, "\n"), 200, $headers);
});



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

Route::get('/reports/summary', 'ReportsController@summary');
Route::post('/reports/summarySearchDate', 'ReportsController@summarySearchDate');
Route::get('/reports', 'ReportsController@index');

Route::post('/reports/disthourajax', 'ReportsController@ajaxdistHour');

Route::get('/reports/technicianStatistics', 'ReportsController@technicianStatistics');
Route::post('/reports/technicianStatisticsSearch', 'ReportsController@technicianStatisticsSearch');

Route::get('/reports/problemMangement', 'ReportsController@problemMangement');
Route::post('/reports/problemMangementDate', 'ReportsController@problemMangementDate');


Route::get('/reports/reportTicketStatus','ReportsController@reportTicketStatus');


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



