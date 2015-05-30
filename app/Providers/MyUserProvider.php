<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth, View;

class MyUserProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer('*', function($view)
    	{
        	$view->with('current_user', Auth::user());
    	});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
