<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use Hash;


class ChangePasswordProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//

		 $this->app['validator']->extend('passmatch', function($attribute, $value, $parameters )
        {
        	$user = User::find($parameters[0]);

            return  ( Hash::check($value  , $user->password ));
        },
        'Old password does not match credentials'
        //"$parameters"
        );
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
