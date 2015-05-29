<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\User;
use Request;
class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users=User::all();
		return view('users.index',compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{



		$user=new User();
		$user->fname=Request::get('fname');
		$user->lname=Request::get('lname');
		$user->email=Request::get('email');
		$user->password=bcrypt(Request::get('password'));
		$user->phone=Request::get('phone');
		$user->location=Request::get('location');
		$user->save();
		return redirect('/users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);
		return view('users.show',compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return view('users.edit',compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user=User::find($id);
		$user->fname=Request::get('fname');
		$user->lname=Request::get('lname');
		$user->email=Request::get('email');
		$user->password=bcrypt(Request::get('password'));
		$user->phone=Request::get('phone');
		$user->location=Request::get('location');
		$user->save();
		 return redirect('/users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user=User::find($id);
		$user->delete();
		//return redirect('/users');
	}



	/**
	 * Select specific users from storage ( called by AJAX).
	 *
	 * @param  string  $type
	 * @return Response
	 */

	public function get_user_types()
	{

		$type = Request::get('type');
		if ($type== "all"){
			
			$selectedUsers =User::all();

		}elseif ($type== "disabled") {
			
			$selectedUsers =User::where('isspam', 1)->get();

		}else{
			$selectedUsers =User::where('type',$type )->get();	
		}
		
		return json_encode($selectedUsers);

	}


	/**
	 * Select users from storage for autocomplete (called by AJAX).
	 *
	 * @param  string  $data
	 * @return Response
	 */

	public function autocomplete()
	{

		$data = Request::get('data');
		$users  = User::select('id', 'fname', 'lname')->where('fname', 'LIKE', "%$data%")->orWhere('lname', 'LIKE', "%$data%")->orWhere('email', 'LIKE', "%$data%")->get();
		
		return json_encode($users);


	}


}	
