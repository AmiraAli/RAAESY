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

use Lang;

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
			return view('errors.authorization');
		}

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
		//authorization
		if (!$this->adminAuth() ){
			return view('errors.authorization');
		}

		if (!empty(Request::get('lang'))  && Request::get('lang') =='ar'){
			Lang::setLocale('ar');
		}else{
			Lang::setLocale('en');
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

		Lang::setLocale('ar');

			$arr = array ();

			$arr['الاسم الأول'] = Request::get('fname');


			$arr['الاسم الثانى'] = Request::get('lname');
			$arr['البريد الإلكترونى'] =  Request::get('email');
			$arr['كلمة المرور'] = Request::get('password');
			$arr['رقم الهاتف'] = Request::get('phone');
			$arr['الموقع'] = Request::get('location');


			if ( Lang::getLocale() == "ar" ){
				$v = Validator::make($arr, [
					'الاسم الأول' => 'required|max:255',
					'الاسم الثانى' => 'required|max:255',
					'البريد الإلكترونى' => 'required|email|max:255|unique:users',
					'كلمة المرور' => 'required|confirmed|min:6',
					'رقم الهاتف' => 'required|numeric',
					'الموقع' => 'required|max:255',

        		]);

			}else{
				$v = Validator::make(Request::all() , [
           			'fname' => 'required|max:255',
					'lname' => 'required|max:255',
					'email' => 'required|email|max:255|unique:users',
					'password' => 'required|confirmed|min:6',
					'phone' => 'required|numeric',
					'location' => 'required|max:255',
        		]);

			}


			
		    
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


			$data = array('fname' => $user->fname,
						  'lname' => $user->lname, 
						  'email' => $user->email,
						  'phone' => $user->phone,
						  'location' => $user->location,
						  'password'=>Request::get('password'),
				    );
		// Mail::send('emails.welcome', $data, function($message) use ($data)
  //           {
  //               $message->from('yoyo80884@gmail.com', "Site name");
  //               $message->subject("Welcome to site name");
  //               $message->to($data['email']);
  //           });


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
			return view('errors.authorization');
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
			return view('errors.authorization');
		}

		//no one can edit the super admin profile ( having id = 1 )		
		if ( $id=="1" && Auth::User()->id != "1" ) {
			return view('errors.authorization');
		}		

		$user = User::find($id);

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

		//add notification wher user deleted
		$this->addnotification("delete"  , "user" , $user );
		$user->delete();
				
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
			return view('errors.authorization');
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

		
		// filter 1: get only displayed user 
		if ($displayedType== "all"){
			
			$users =User::all();

		}elseif ($displayedType== "disabled") {
			
			$users =User::where('isspam', 1)->get();

		}else{
			$users =User::where('type',$displayedType )->get();	
		}
		
		// filter 2: get specified users from advanced search
		
		if ($fname != null) {
			
			$users = $users->where('fname' , $fname);
		}
		if ($lname != null) {
			
			$users = $users->where('lname' , $lname);
		}
		if ($email != null) {
			
			$users = $users->where('email' , $email);
		}
		if ($phone != null) {
			
			$users = $users->where('phone' , $phone);
		}
		if ($location != null) {
			
			$users = $users->where('location', $location);
		}

		return view('users.ajaxsearch',compact('users'));

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
	


	public function downloadPDF()
	{
		

	    /*$filename = "users.pdf";
	    $handle = fopen($filename, 'w+');

	    
	    fputpdf($handle, array('id', 'First name', 'Last name', 'Email' ,'Phone' ,'Location' , 'Disabled' , 'Type' , 'Remember token' , 'Created at' , 'Updated at'));


	    //put all fields except password
	    foreach($users as $row) {
	        fputpdf($handle, array($row['id'], $row['fname'], $row['lname'], $row['email'] , $row['phone'] , $row['location'] , $row['isspam'] , $row['type'] , $row['remember_token'] ,$row['created_at']  , $row['updated_at']));
	    }

	    fclose($handle);*/
	    /*$articles=Article::all();
    	$output = implode(",", array('Subject', 'Category','How can See It!?','Owner','Created_at','Updated_at'))."\n";
    	foreach ($articles as $article) {
		// iterate over each tweet and add it to the csv
			if ($article->isshow==1){
                    $show="Technicals only";
            }else{
                    $show="Technicals and Users"; 
            } 	
		    $output .= implode(",", array($article->subject , $article->category->name , $show , $article->user->fname ,  $article->created_at ,$article->updated_at)); // append each row
			$output .="\n";

		}

    	$headers = array(
        'Content-Type: application/pdf',
        'Content-Disposition:attachment; filename="cv.pdf"',
        'Content-Transfer-Encoding:binary',
        //'Content-Length:'.filesize($filename),
 	   );

	    return Response::make(rtrim($output, "\n"), 200, $headers);

		//return response()->download($filename, "CV.pdf");	*/
		$pdf = App::make('dompdf');
		$pdf->loadView('users.index', array());
		return $pdf->download('invoice.pdf');	
	}

}	
