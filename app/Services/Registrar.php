<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Mail;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'fname' => 'required|max:255',
			'lname' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'phone' => 'required|max:255',
			'location' => 'required|max:255',
			'captcha' => 'required|captcha',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$user = User::create([
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'phone' => $data['phone'],
			'location' => $data['location'],



		]);
		$data['verification_code']  = $user->verification_code;


		// Mail::send('emails.welcome', $data, function($message) use ($data)
  //           {
  //               $message->from('yoyo80884@gmail.com', "RSB");
  //               $message->subject("Welcome to RSB");
  //               $message->to($data['email']);
  //           });

		return $user;
	}

}
