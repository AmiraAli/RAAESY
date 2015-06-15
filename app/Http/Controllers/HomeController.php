<?php namespace App\Http\Controllers;
use Auth;
use Mail;
use App\Category;
use App\Article;
use Request;
use DB;
use Session;


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
		if(Auth::user()->type === "admin" || Auth::user()->type === "tech"){
			$articles=Article::paginate(6);
			$categories = DB::select("select articles.category_id, categories.name,count(*) as count from articles join categories on categories.id = articles.category_id group by category_id");

		}
		else{
			$articles=Article::where("isshow", 1)->paginate(6);
			$categories = DB::select("select articles.category_id, categories.name,count(*) as count from articles join categories on categories.id = articles.category_id where isshow = 1 group by category_id");

		}

		$countArticle=Article::All()->count();

		return view('home',compact('categories','articles','countArticle'));
	}

	// public function home()
 //    {
 //        Mail::send('emails.password', array('name' => 'The New Topic'),   function($message){
 //        $message->to('rababzein2012@gmail.com', 'The New Topic')->subject('Test Email');

 //    });
 //    return View::make('home');
 //    }

	public function searchArticle()
	{
		if(Request::ajax()){ 
			if(Auth::user()->type === "admin" || Auth::user()->type === "tech"){
				$articles = Article::select("*");
			}
			else{
				$articles = Article::where("isshow", 1);
			}
			if(Request::input('cat')){
				if(Request::input('cat') != "all"){
					$articles = $articles->where('category_id', Request::input('cat'));
				}
			}
			else if(Request::input('sec')){
				
				$categories = Category::select("id")->where("section_id", Request::input('sec'))->get();
				$i = 0;
				foreach ($categories as $key => $value) {
					$arr[$i] = $value->id;
					$i++;
				}

				$articles = $articles->whereIn('category_id', $arr);
			}
			$articles = $articles->paginate(6);

			return view('searchArticle',compact('articles'));
		}
	}

	/**
	 * Change the language in session ( called by AJAX )
	 *
	 * @return Response
	 */

	public function changeLang(){      


		if (Request::get('lang') =='ar'){
			Session::set('locale', 'ar');
		}else{
			Session::set('locale', 'en');
		}

		return redirect()->back();
	}





}
