<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Log;
use Request;
use Validator;
use Mail;
class UsersController extends Controller {



	public function __construct()
	{
		$this->middleware('auth');
	}

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


		    $v = Validator::make(Request::all(), [
           			'fname' => 'required|max:255',
					'lname' => 'required|max:255',
					'email' => 'required|email|max:255|unique:users',
					'password' => 'required|confirmed|min:6',
					'phone' => 'required|numeric',
					'location' => 'required|max:255',
        	]);
        $subject=Request::get('subject');

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{

			$user=new User();
            $user->fname=Request::get('fname');
			$user->lname=Request::get('lname');
			$user->email=Request::get('email');
			$user->password=bcrypt(Request::get('password'));
			$user->phone=Request::get('phone');
			$user->location=Request::get('location');
			

			if (Request::get('isspam')){
				$user->isspam= 1;
			
			}else{
				$user->isspam=0;

			}
			$user->type=Request::get('type');

			$user->save();

			if ($user->isspam == 1){

				//add notification in log
				$this->addnotification("spam"  , "user" , $user );
			}


			//$data['verification_code']  = $user->verification_code;

		//Session::put('email', $data['email']);
			$data = array('fname' => $user->fname,
						  'lname' => $user->lname, 
						  'email' => $user->email,
						  'phone' => $user->phone,
						  'location' => $user->location,
						  'password'=>Request::get('password'),
				    );
		Mail::send('emails.welcome', $data, function($message) use ($data)
            {
                $message->from('yoyo80884@gmail.com', "Site name");
                $message->subject("Welcome to site name");
                $message->to($data['email']);
            });


			return redirect('/users');
	    }


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
		$v = Validator::make(Request::all(), [
           			'fname' => 'required|max:255',
					'lname' => 'required|max:255',
					'email' => 'required|email|max:255',
					'phone' => 'required|max:20|numeric',
					'location' => 'required|max:255',
        	]);
        $subject=Request::get('subject');

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{

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
	 * Show the form for changing password.
	 *
	 * @return Response
	 */
	public function changepassword()
	{
		
		return view('users.changepassword');
	}


	/**
	 * Perform changing password process.
	 * @param  string  $newPass
	 *
	 * @return Response
	 */
	public function changepassprocess()
	{

		//$user_id = Auth::User()->id;
		$v = Validator::make(Request::all(), [
					'password' => 'required'
					//'oldpassword' => "required|exists:users,id,$user_id",

        	]);
        
	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{

	    		echo "jun";
	    		exit;

		// 	$user=User::find($id);
		// $user->fname=Request::get('fname');
		// $user->lname=Request::get('lname');
		// $user->email=Request::get('email');
	    	   // return redirect()->back();
		
		}

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
	
		return view('users.search');

	}



	public function ajaxsearch()
	{
		$fname = Request::get('fname');
		$lname = Request::get('lname');
		$email = Request::get('email');
		$phone = Request::get('phone');
		$location = Request::get('location');
		//all
		if ($fname != null && $lname != null && $email != null && $phone != null && $location != null) {
		
			$users = User::whereFnameAndLnameAndEmailAndPhoneAndLocation($fname,$lname,$email,$phone,$location)->get();
			
	    }

	    // all expect location

	    if ($fname != null && $lname != null && $email != null && $phone != null && $location == null) {
			
			$users = User::whereFnameAndLnameAndEmailAndPhone($fname,$lname,$email,$phone)->get();
			
	    }


	    // all expect location & phone
	    if ($fname != null && $lname != null && $email != null && $phone == null && $location == null) {

			$users = User::whereFnameAndLnameAndEmail($fname,$lname,$email)->get();
			
	    }

	    // fname & lname

	    if ($fname != null && $lname != null && $email == null && $phone == null && $location == null) {

			$users = User::whereFnameAndLname($fname,$lname)->get();
			
	    }

	    // fname
	    if ($fname != null && $lname == null && $email == null && $phone == null && $location == null) {

			$users = User::whereFname($fname)->get();
			
	    }

	    // lname
	    if ($fname == null && $lname != null && $email == null && $phone == null && $location == null) {

			$users = User::whereLname($lname)->get();
			
	    }

	    //email
	    if ($fname == null && $lname == null && $email != null && $phone == null && $location == null) {

			$users = User::whereEmail($email)->get();
			
	    }

	    //phone
	    if ($fname == null && $lname == null && $email == null && $phone != null && $location == null) {

			$users = User::wherePhone($phone)->get();
			
	    }

	    //location
	    if ($fname == null && $lname == null && $email == null && $phone == null && $location != null) {

			$users = User::whereLocation($location)->get();
			
	    }

	    // all expect fname
	    if ($fname == null && $lname != null && $email != null && $phone != null && $location != null) {
		
			$users = User::whereLnameAndEmailAndPhoneAndLocation($lname,$email,$phone,$location)->get();
			
	    }

	    //email phone location 
	    if ($fname == null && $lname == null && $email != null && $phone != null && $location != null) {
		
			$users = User::whereEmailAndPhoneAndLocation($email,$phone,$location)->get();
			
	    }

	    //phone location
	    if ($fname == null && $lname == null && $email == null && $phone != null && $location != null) {
		
			$users = User::wherePhoneAndLocation($phone,$location)->get();
			
	    }

	    // all expext lname
	    if ($fname != null && $lname == null && $email != null && $phone != null && $location != null) {
		
			$users = User::whereFnameAndEmailAndPhoneAndLocation($fname,$email,$phone,$location)->get();
			
	    }

	    //fname phone location 
	    if ($fname != null && $lname == null && $email == null && $phone != null && $location != null) {
		
			$users = User::whereFnameAndPhoneAndLocation($fname,$phone,$location)->get();
			
	    }

	    //fname location
        if ($fname != null && $lname == null && $email == null && $phone == null && $location != null) {
		
			$users = User::whereFnameAndLocation($fname,$location)->get();
			
	    }

	    //all expect email
	    if ($fname != null && $lname != null && $email == null && $phone != null && $location != null) {
		
			$users = User::whereFnameAndLnameAndPhoneAndLocation($fname,$lname,$phone,$location)->get();
			
	    }
	    // fname lname location
	    if ($fname != null && $lname != null && $email == null && $phone == null && $location != null) {
		
			$users = User::whereFnameAndLnameAndLocation($fname,$lname,$location)->get();
			
	    }

	    //all expect phone
	    if ($fname != null && $lname != null && $email != null && $phone == null && $location != null) {
		
			$users = User::whereFnameAndLnameAndEmailAndLocation($fname,$lname,$email,$location)->get();
			
	    }
        //fname lname Email
        if ($fname != null && $lname != null && $email != null && $phone == null && $location == null) {
		
			$users = User::whereFnameAndLnameAndEmail($fname,$lname,$email)->get();
			
	    }

	    //fname & phone
	    if ($fname != null && $lname == null && $email == null && $phone != null && $location == null) {
		
			$users = User::whereFnameAndPhone($fname,$phone)->get();
			
	    }

	    //lname & phone 
	    if ($fname == null && $lname != null && $email == null && $phone != null && $location == null) {
		
			$users = User::whereLnameAndPhone($lname,$phone)->get();
			
	    }

	    //email & phone 
	    if ($fname == null && $lname == null && $email != null && $phone != null && $location == null) {
		
			$users = User::whereEmailAndPhone($email,$phone)->get();
			
	    }

	    //email & lname 
	    if ($fname == null && $lname != null && $email != null && $phone == null && $location == null) {
		
			$users = User::whereEmailAndLname($email,$lname)->get();
			
	    }

	    //email & fname 
	    if ($fname != null && $lname == null && $email != null && $phone == null && $location == null) {
		
			$users = User::whereEmailAndFname($email,$fname)->get();
			
	    }

		return view('users.ajaxsearch',compact('users'));

	}



	
	

}	
