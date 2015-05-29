<?php namespace App\Http\Controllers;
use Auth;
use Mail;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	// public function home()
 //    {
 //        Mail::send('emails.password', array('name' => 'The New Topic'),   function($message){
 //        $message->to('rababzein2012@gmail.com', 'The New Topic')->subject('Test Email');

 //    });
 //    return View::make('home');
 //    }

}
