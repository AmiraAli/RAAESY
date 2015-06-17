<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Log;
use Request;
use Validator;
use Mail;
use Response;
use App\Article;
use App;
use Session;

class UsersController extends Controller {



	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Authorize admin
	 * @param  integer $user_id
	 * @return Response
	 */
	private function adminAuth()
	{		
		if (Auth::User()->type !="admin"){
			return false;
		}
		return true;
	}

	/**
	 * Authorize user can view the page
	 *
	 * @return Response
	 */
	private function userAuth($id)
	{		
		if (Auth::User()->id !=$id ){
			return false;
		}
		return true;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//authenticate admin
		if (!$this->adminAuth()){
			return view('errors.404');
		}

		$users=User::where('isspam', 0)->paginate(5);
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
		//authorization
		if (!$this->adminAuth() ){
			return view('errors.404');
		}

		return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if (Session::get('locale') =="ar"){
	
			$arr = array ();

			//set validation array with arabic field names
			$arr['الاسم الأول'] = Request::get('fname');
			$arr['الاسم الأخير'] = Request::get('lname');
			$arr['البريد الإلكترونى'] =  Request::get('email');
			$arr['كلمة المرور'] = Request::get('password');
			$arr['رقم الهاتف'] = Request::get('phone');
			$arr['الموقع'] = Request::get('location');
			$arr['email'] =  Request::get('email');
			$arr['كلمة المرور_confirmation'] =  Request::get('password_confirmation');



			$messages = array(
  			  'email.unique' => 'البريد الإلكترونى الذى ادخلته مأخوذ مسبقاً',
			);
			
			//validation
			$v = Validator::make($arr, [
					'الاسم الأول' => 'required|max:15',
					'الاسم الأخير' => 'required|max:15',
					'البريد الإلكترونى' => 'required|email|max:40',
					'email' => 'unique:users' , 
					'كلمة المرور' => 'required|min:6|confirmed', 
					'رقم الهاتف' => 'required|numeric',
					'الموقع' => 'required|max:255',

        	] , $messages );


		}else{
				$v = Validator::make(Request::all() , [
           			'fname' => 'required|max:15',
					'lname' => 'required|max:15',
					'email' => 'required|email|max:40|unique:users',
					'password' => 'required|confirmed|min:6',
					'phone' => 'required|numeric',
					'location' => 'required|max:255',
        		]);

		}


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
			$user->isspam= 0;
			$user->type=Request::get('type');

			$user->save();

			if ($user->isspam == 1){

				//add notification in log
				$this->addnotification("spam"  , "user" , $user );
			}


			$data = array('fname' => $user->fname,
						  'lname' => $user->lname, 
						  'email' => $user->email,
						  'phone' => $user->phone,
						  'location' => $user->location,
						  'password'=>Request::get('password'),
				    );
			
			if (!empty (Request::get('sendMsg')) ) {
				Mail::send('emails.welcome', $data, function($message) use ($data)
	            {
	                $message->from('yoyo80884@gmail.com', "RSB");
	                $message->subject("Welcome to RSB");
	                $message->to($data['email']);
	            });
			}


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
		//authorization
		if (!$this->adminAuth() && !$this->userAuth($id)){
			return view('errors.404');
		}

		$user = User::find($id);
		if (empty($user)){
			return view('errors.404');
		}
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
		
		//authorization
		if (!$this->adminAuth() && !$this->userAuth($id)){
			return view('errors.404');
		}

		//no one can edit the super admin profile ( having id = 1 )	
		//only super user can edit admins profile	
		$userType = User::find($id)->type;
		if ( Auth::User()->id != "1" && $userType=="admin" && !($this->userAuth($id)) ){
			return view('errors.404');
		}

		$user = User::find($id);
		if (empty($user)){
			return view('errors.404');
		}

		return view('users.edit',compact('user', 'id'));
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
					'phone' => 'required|numeric',
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
			$user->phone=Request::get('phone');
			$user->location=Request::get('location');

			if (Request::get('type')){
				$user->type=Request::get('type');
			}
							

			$user->save();
			 return redirect('/users/'.$user->id.'/');
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

		//add notification when user deleted
		$this->addnotification("delete"  , "user" , $user );
		$user->delete();
				
	}

	/**
	 * spam/unspam user ( called by AJAX )
	 *
	 * @param  int  $id, int spam
	 * @return Response
	 */
	public function spam($id)
	{
		
		if(!Request::ajax()) {
			return;
		}

		$user=User::find($id);

		$user->isspam=Request::get('spam');
		$user->save();
		
		//add notification when user deleted
		if (Request::get('spam') == 1){
			$this->addnotification("spam"  , "user" , $user );
		}
				
	}





	/**
	 * Show the form for changing password.
	 *
	 * @return Response
	 */
	public function changepassword($id)
	{
		//authorization
		if (!$this->userAuth($id)){
			return view('errors.404');
		}
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

		$user_id = Auth::User()->id;

		$v = Validator::make( Request::all() , [
					'oldPassword' => "required|passmatch:$user_id",
					'newPassword' => 'required|confirmed|min:6',
		]);
        
	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors())
	        						 ->withInput();
	    }else{

	    		

		 	$user=User::find($user_id);
		    $user->password = bcrypt(Request::get('newPassword'));
			$user->save();
			$status = "Your password has been changed successfully.";
			return view('users.changepassword', compact('status'));

		}

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
	 * Search and advanced search for users (called by AJAX).
	 *
	 * @param  string  $displayedType and ( $fname , $lname , ... (optional fields) )
	 * @return Response
	 */

	public function ajaxsearch()
	{
		$fname = Request::get('fname');
		$lname = Request::get('lname');
		$email = Request::get('email');
		$phone = Request::get('phone');
		$location = Request::get('location');
		$displayedType = Request::get('displayed');
		

		//to show user type in the table
		$showType = false;
		
		// filter 1: get only displayed user 
		if ($displayedType== "all"){
			
			$users =User::where('isspam', 0);

		}elseif ($displayedType== "disabled") {
			
			$users =User::where('isspam', 1);
			$showType = true;

		}else{
			$users =User::where('type',$displayedType )->where('isspam', 0);
		}
		
		// filter 2: get specified users from advanced search
		
		if ($fname != null) {
			
			$users = $users->where('fname' ,'like' ,  "%$fname%");
		}
		if ($lname != null) {
			
			$users = $users->where('lname' , 'like' , "%$lname%");
		}
		if ($email != null) {
			
			$users = $users->where('email' , 'like' , "%$email%");
		}
		if ($phone != null) {
			
			$users = $users->where('phone' , 'like' , "%$phone%");
		}
		if ($location != null) {
			
			$users = $users->where('location', 'like' , "%$location%" );
		}

		$users = $users->paginate(5);

		return view('users.ajaxsearch',compact('users', 'showType' ));

	}


	/**
	 * Download users list as CSV file
	 *
	 * @return Response
	 */

	public function downloadCSV()
	{
		
		$users=User::all();

	    $filename = "users.csv";
	    $handle = fopen($filename, 'w+');

	    
	    fputcsv($handle, array('id', 'First name', 'Last name', 'Email' ,'Phone' ,'Location' , 'Disabled' , 'Type'  , 'Created at' , 'Updated at'));


	    //put all fields except password
	    foreach($users as $row) {
	        fputcsv($handle, array($row['id'], $row['fname'], $row['lname'], $row['email'] , $row['phone'] , $row['location'] , $row['isspam'] , $row['type'] ,$row['created_at']  , $row['updated_at']));
	    }

	    fclose($handle);

	    $headers = array(
	        'Content-Type' => 'text/csv',
	    );

	    return Response::download($filename, 'users.csv', $headers);
		
	}


	

	

}	
