<?php namespace App\Http\Middleware;

use Session;
use Lang;

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
		if (Session::has('locale')){
			Lang::setLocale(Session::get('locale'));

		}

		return $next($request);
	}

}
