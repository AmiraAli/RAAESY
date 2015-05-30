<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Log;
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
	 * Notify when user is spam/delete (called by AJAX).
	 *
	 * @param  object  $model_obj , string action
	 * @return Response
	 */

	private function addnotification($action , $type , $model_obj ){

		$notification = new Log();
		$notification->type = $type ;
		$notification->action = $action;
		$notification->name = $model_obj->fname." ".$model_obj->lname;
		$notification->type_id = $model_obj->id;
		$notification->user_id = Auth::user()->id;
		$notification->save();

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
		$user->isspam=Request::get('isspam');
		$user->type=Request::get('type');

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
		//$user->password=bcrypt(Request::get('password'));
		$user->phone=Request::get('phone');
		$user->location=Request::get('location');

		if (Request::get('isspam')){
			
			//check if admin soan a user
			if ($user->isspam == 0){

				//add notification in log
				$this->addnotification("spam"  , "user" , $user );
			}
			$user->isspam= 1;

		}else{
			$user->isspam=0;

		}
		$user->type=Request::get('type');
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

		//add notification wher user deleted
		$this->addnotification("delete"  , "user" , $user );
		$user->delete();
				
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



	/**
	 * Search users (called by AJAX).
	 *
	 * @param  string  $fname , $lname , ... (optional fields)
	 * @return Response
	 */

	public function search()
	{

	
		echo "ok";
		exit;



	}



	
	

}	
