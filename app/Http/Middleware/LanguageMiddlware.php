<?php namespace App\Http\Middleware;

use Session;
use Lang;
use Illuminate\Routing\Route;

use Closure;

class LanguageMiddlware {

	/**
	 * Handle an incoming request and set the language.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		 	if (Session::has('locale')  ){

		 		$action = "";
		 		$controller  = $request->segments()[0];

		 		if (isset($request->segments()[1]) ){
		 			$action =$request->segments()[1];
		 		}

		 		
		 		/*  change language in these cases only users/create , 
		 		 *  or reports controller (supported till now)
		 		 */

		 		if ( $controller!="users" && $action!="create" && $controller!="reports"){
		 			Lang::setLocale('en') ;
		 		}else{
		 			Lang::setLocale(Session::get('locale'));
		 		}

		 	}
		

		return $next($request);
	}

}
