<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Auth;
use DB;
//use Request;
use App\Subject;
use App\Ticket;
use App\Category;
use App\Section;
use App\User;
use App\Comment;
use App\TicketTag;

use App\Tag;
use App\TicketStatus;
use App\Asset;
use App\TicketAsset;

use Carbon\Carbon;

use App\Log;
use Mail;
use Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TicketsController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Notify when ticket is spam/delete (called by AJAX).
	 *
	 * @param  object  $model_obj , string action
	 * @return Response
	 */

	private function addnotification($action , $type , $model_obj ){

		$notification = new Log();
		$notification->type = $type ;
		$notification->action = $action;
		$notification->name = $model_obj->subject->name;
		$notification->type_id = $model_obj->id;
		$notification->user_id = Auth::user()->id;
		$notification->save();

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$paginateNumber= 5;

		$tags=Tag::all();

		if(Auth::user()->type === "admin"){
			//all tickets except spam tickets
			$ticketPag = Ticket::where('is_spam', "0")->paginate(5);
			

			$allcount=Ticket::where('is_spam', "0")->count();

			//sort array
			$tickets= $this->sortTicket ( $ticketPag ,"subject" ,"DESC");

			//set default path
			$ticketPag->setPath('/tickets/searchTicket');

			//pagination
			/*if($request->has('page')){
				$tickets=array_slice ( $tickets ,($request->get('page')-1)*$paginateNumber );
			}
			$tickets=new Paginator($tickets, $paginateNumber);*/
			



			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();

			$technicals=User::where('type','=','tech')->get();
			$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 group by category_id");


			return view('tickets.index',compact('tickets','ticketPag' , 'unassigned','open','closed','expired','spam','tags','technicals','unanswered','categories','allcount'));
		}
		else if(Auth::user()->type === "tech"){
			$ticketPag = Ticket::where('is_spam', "0")->where('tech_id', $request->user()->id)->paginate(5);
			$tickets= $this->sortTicket ( $ticketPag ,"subject" ,"DESC");
			
			//pagination
			/*if($request->has('page')){
				$tickets=array_slice ( $tickets ,($request->get('page')-1)*$paginateNumber );
			}
			$tickets=new Paginator($tickets, $paginateNumber);*/

			//set default path
			$ticketPag->setPath('/tickets/searchTicket');

			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('tech_id', $request->user()->id)->where('is_spam', "0")->get();
			// open tickets except spam tickets

			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('tech_id', $request->user()->id)->where('is_spam', "0")->get();
			$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and tech_id = ? group by category_id", array($request->user()->id));

			return view('tickets.index',compact('tickets' , 'ticketPag','open','closed','tags','categories'));
		}
		else if(Auth::user()->type === "regular"){
			$ticketPag = Ticket::where('is_spam', "0")->where('user_id', $request->user()->id)->paginate(5);
			
			$tickets= $this->sortTicket ( $ticketPag ,"subject" ,"DESC");
			


			//set default path
			$ticketPag->setPath('/tickets/searchTicket');
			
			//pagination 
			/*if($request->has('page')){
				$tickets=array_slice ( $tickets ,($request->get('page')-1)*$paginateNumber );
			}
			$tickets=new Paginator($tickets, $paginateNumber);*/
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('user_id', $request->user()->id)->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('user_id', $request->user()->id)->where('is_spam', "0")->get();
			$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and user_id = ? group by category_id", array($request->user()->id));

			return view('tickets.index',compact('tickets' , 'ticketPag' ,'open','closed','tags','categories'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$subjects=Subject::all();
		$categories=Category::all();
		$sections=Section::all();
		// render all technical users who has tickets < 5
		$users=array();
		$users_tech=User::where('type','tech')->get();
		for($i=0;$i<count($users_tech);$i++){
			$count=Ticket::where('tech_id',$users_tech[$i]->id)->count();
			if($count<5){
				array_push($users,$users_tech[$i]);
			}
		}
		return view('tickets.create',compact('subjects','categories','sections','users'));
	}

	
		/**
		* Store a newly created resource in storage.
		*
		* @return Response
		*/
		public function store(Request $request)
		{
			$this->validate($request, [
			'description' => 'required',
			'subject' =>'required',
			'category'=>'required'
			]);
			$ticket= new Ticket;
			$ticket->description=$request->get('description');

			//check for uploaded file and store it n public path
			if ($request->hasFile('file')) { 
				$destination='files/';
				$filename=str_random(6)."_".$request->file('file')->getClientOriginalName();
				$request->file('file')->move($destination,$filename);
				$ticket->file=$filename;
			}else{
				$ticket->file=$request->get('file');
			}


			$ticket->category_id=$request->get('category');
			$ticket->subject_id=$request->get('subject');
			$ticket->user_id=Auth::user()->id;
		if(Auth::user()->type === "admin")
		{
			$ticket->priority=$request->get('priority');
			$ticket->deadline=$request->get('deadline');
			if($request->get('tech') == ""){
				$ticket->tech_id = null;
			}else{
				$ticket->tech_id=$request->get('tech');
			}
			$ticket->admin_id=$request->user()->id;
			$ticket->save();

			// save ticket as open status in ticket status table
			$ticketStatus=new TicketStatus;
			$ticketStatus->value='open';
			$ticketStatus->ticket_id=$ticket->id;
			$ticketStatus->save();

			//insert into table ticket_tags each tag of this ticket
			$tags=$request->get('tagValues');
			if( $tags != ""){
				$tags_array=explode(",",$tags);
				for($i=0;$i<count($tags_array);$i++){
					$tag=Tag::where('name',$tags_array[$i])->first();
					$ticketTag=new TicketTag;
					$ticketTag->tag_id=$tag->id;
					$ticketTag->ticket_id=$ticket->id;
					$ticketTag->save();
				}
			}

			// check if assigned to technical will send mail to him

			// if($request->get('tech')){

			// 	$ticket_array=json_decode(json_encode($ticket), true);
			// 	$ticket_array['verification_code']  = $ticket->verification_code;
			// 	$ticket_array['tech_fname']=$ticket->tech->fname;
			// 	$ticket_array['tech_lname']=$ticket->tech->lname;
			// 	$ticket_array['tech_email']=$ticket->tech->email;
			// 	$ticket_array['subj_name']=$ticket->subject->name;

			// 	Mail::send('emails.techassigned', $ticket_array, function($message) use ($ticket_array)
   //          	{
	  //               $message->from('yoyo80884@gmail.com', "RAAESY");
	  //               $message->subject("RAAESY");
	  //               $message->to($ticket_array['tech_email']);
   //          	});
			// }

		}else{
			$ticket->tech_id=NULL;
			$ticket->admin_id=NULL;
			$ticket->deadline=date('Y-m-d', strtotime('+1 day'));
			$ticket->save();

			// save ticket as open status in ticket status table
			$ticketStatus=new TicketStatus;
			$ticketStatus->value='open';
			$ticketStatus->ticket_id=$ticket->id;
			$ticketStatus->save();
		}
		return redirect('/tickets');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	$ticket=Ticket::find($id);
	// Get Related Tags

	$relatedTagIds = Ticket::find($id)->TicketTags;

	$relatedIds=array();
	foreach($relatedTagIds as $relatedTagId){
	$relatedIds[]=$relatedTagId->id;
	}

	$relatedTickets=Ticket::join('ticket_tags', 'tickets.id', '=', 'ticket_tags.ticket_id')
	->whereIn('ticket_tags.tag_id',$relatedIds)->groupBy('tickets.id')->get();

	#file_put_contents("/home/aya/teesst.html", $relatedTickets);

	// Get Related Assests

	$relatedAssets = Ticket::find($id)->TicketAssets;
	// $relatedAssets = TicketAsset::where("ticket_id", $id)->get();
//$relatedAssets = Ticket::join('ticket_assets', 'tickets.id', '=', 'ticket_assets.ticket_id')->where('tickets.id','=',$id)->get();
	//get all comments
	$comments=Ticket::find($id)->comments;

	// Check status of ticket closed or open
	//$checkStatus=TicketStatus::where('ticket_id', $id)->first();

	

	//get assigned to and user created it
	//$users=Ticket::find($id)->user;

	return view('tickets.show',compact('ticket','relatedTickets','relatedAssets','comments'));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ticket=Ticket::find($id);
		$subjects=Subject::all();
		$categories=Category::all();
		$sections=Section::all();
		// render all technical users who has tickets < 5
		$assign_tech=User::where('id',$ticket->tech_id)->first();
		$users=array();
		$users_tech=User::where('type','tech')->get();
		for($i=0;$i<count($users_tech);$i++){
			$count=Ticket::where('tech_id',$users_tech[$i]->id)->count();
			if($count<5){
				array_push($users,$users_tech[$i]);
			}
		}
		return view('tickets.edit',compact('ticket','subjects','categories','sections','users','assign_tech'));
	}

	
	/**
	* Update the specified resource in storage.
	*
	* @param int $id
	* @return Response
	*/
	public function update($id,Request $request)
	{
		$this->validate($request, [
		'description' => 'required',
		'subject' =>'required',
		'category'=>'required'
		]);

		$ticket= Ticket::find($id);
		$ticket->description=$request->get('description');
		$ticket->priority=$request->get('priority');

		//check for uploaded file and store it n public path
			if ($request->hasFile('file')) { 
				$destination='files/';
				$filename=str_random(6)."_".$request->file('file')->getClientOriginalName();
				$request->file('file')->move($destination,$filename);
				$ticket->file=$filename;
			}else{
				$ticket->file=$ticket->file;
			}
		$ticket->category_id=$request->get('category');
		$ticket->subject_id=$request->get('subject');
		$ticket->user_id=Auth::user()->id;

		if(Auth::user()->type === "admin")
		{
			$ticket->priority=$request->get('priority');
			$ticket->deadline=$request->get('deadline');

			$prev_tech_id=$ticket->tech_id;

			if($request->get('tech') == ""){
				$ticket->tech_id = null;
			}else{
				$ticket->tech_id=$request->get('tech');
			}


			//$ticket->tech_id=$request->get('tech');
			$ticket->admin_id=Auth::user()->id;
			$ticket->save();

			// check if tags of ticket is changed or not
			$tags=$request->get('tagValues');
			if( $tags != ""){
				// remove all prev tags
				$prevTicketTags=TicketTag::where('ticket_id',$id);
				$prevTicketTags->delete();
				//insert into table ticket_tags each tag of this ticket
				$tags_array=explode(",",$tags);
				for($i=0;$i<count($tags_array);$i++){
					$tag=Tag::where('name',$tags_array[$i])->first();
					$ticketTag=new TicketTag;
					$ticketTag->tag_id=$tag->id;
					$ticketTag->ticket_id=$ticket->id;
					$ticketTag->save();
				}
			}

			// check if assigned to another technical will send mail to him

			// if($request->get('tech') != $prev_tech_id){

			// 	$ticket_array=json_decode(json_encode($ticket), true);
			// 	$ticket_array['verification_code']  = $ticket->verification_code;
			// 	$ticket_array['tech_fname']=$ticket->tech->fname;
			// 	$ticket_array['tech_lname']=$ticket->tech->lname;
			// 	$ticket_array['tech_email']=$ticket->tech->email;
			// 	$ticket_array['subj_name']=$ticket->subject->name;

			// 	Mail::send('emails.techassigned', $ticket_array, function($message) use ($ticket_array)
   //          	{
	  //               $message->from('yoyo80884@gmail.com', "RAAESY");
	  //               $message->subject("RAAESY");
	  //               $message->to($ticket_array['tech_email']);
   //          	});
			// }

		}else{
			$ticket->tech_id=NULL;
			$ticket->admin_id=NULL;
			$ticket->save();
		}
		return redirect("/tickets/".$id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$ticket=Ticket::find($id);

		// add the deleted ticket to log table
		$this->addnotification("delete","ticket",$ticket);

		$ticket->delete();

		$tickets = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "0")->get();
			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();
	        			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();

	        $data["all"] = $tickets[0]->count;
	        $data["unassigned"] = $unassigned[0]->count;
	        $data["closed"] = $closed[0]->count;
	        $data["open"] = $open[0]->count;
	        $data["expired"] = $expired[0]->count;
	        $data["unanswered"] = count($unanswered);
	        $data["spam"] = $spam[0]->count;

			echo json_encode($data);
	}
	

	/**
	* Function to add subject for ticket
	**/
	public function addSubject(Request $request)
	{
		// Getting post data
		if($request->ajax()) {
			// $data = Input::all();
			$data = $request->input('newsubj');
			$subject= new Subject;
			$subject->name=$data;
			$subject->save();
			print_r($subject->id);
		}
	}

	/**
	* Function to get all tags by autocomplete
	**/
	public function getTags(Request $request)
	{
		// Getting post data
		if($request->ajax()) {
			// $data = Input::all();
			$data = $request->input('q');
			$tags=Tag::select('name')->where('name','like',"%".$data.'%')->get();
			// file_put_contents("/home/amira/test.html", $tags);
			echo json_encode($tags);
		}
	}
	/**
	* Function to update status of ticket
	**/
	public function updatestatus(Request $request)

	{
		// update ticket_statuses with new state [closed-open]
		if($request->ajax()) {
		$ticket_id = $request->input("ticket_id");
		$status = $request->input("status");
							}




		$ticketStatus=Ticket::find($ticket_id);
		$ticketStatus->status=$status;
		$ticketStatus->save();


		$ticketStatuses=new TicketStatus;
		$ticketStatuses->value=$status;
		$ticketStatuses->ticket_id=$ticket_id;
		$ticketStatuses->save();
	
		//$ticketStatus=TicketStatus::where('ticket_id', $ticket_id)->first();
		//$ticketStatus->value=$status;
		//$ticketStatus->save();

		// save notification
		$readonly=0;
		if($status=='close')
		$body="this ticket has be closed";
		if($status=='open')
		$body="this ticket has been re-opened";	
		$notify= new Comment;
		$notify->body=$body;
		$notify->readonly=intval($readonly);
		$notify->ticket_id=intval($ticket_id);
		$notify->user_id=Auth::user()->id;
		$notify->save();
		$notify->fname=Auth::user()->fname;
		$notify->lname=Auth::user()->lname;
		echo json_encode($notify);
		//file_put_contents("/home/aya/teesst.html", $notify);

	}

	/**
	* Function to sort tickets
	**/
	public function sortTicket( $tickt , $sortBy ,$sortType )
	{
		if(is_object($tickt) &&  ! $tickt->isEmpty())
		{		
    		$tickets = array();
	    			    	
	        foreach ($tickt as $key => $value)
	        {	        
	            $tickets[$key] = $value;
            
	        }
	        foreach ($tickets as $key => $row)
			{
				if ($sortBy == "subject") 
				{		
					$sort[$key] = $row['subject']['name'];
				}
				else 
				{
					$sort[$key] = $row[$sortBy];
				}			    				    
			}


			//sorting function
			if ($sortType == "DESC") 
			{	
				if($sortBy == "priority")
				{
					array_multisort($sort, SORT_DESC, $tickets);
				}
				else
				{	
					array_multisort($sort, SORT_ASC, $tickets);
				}
			}
			elseif ($sortType == "ASC")
			{
				if($sortBy == "priority")
				{
					array_multisort($sort, SORT_ASC, $tickets);
				}
				else
				{	
					array_multisort($sort, SORT_DESC, $tickets);
				}
			}
			return $tickets; 
		}	
	   
	    elseif ( is_array($tickt) && !empty($tickt)) 
		{
			foreach ($tickt as $key => $row)
			{
				if ($sortBy == "subject") 
				{		
					$sort[$key] = $row['subject']['name'];
				}
				else 
				{
					$sort[$key] = $row[$sortBy];
				}			    				    
			}


			//sorting function
			if ($sortType == "DESC") 
			{	
				if($sortBy == "priority")
				{
					array_multisort($sort, SORT_DESC, $tickt);
				}
				else
				{	
					array_multisort($sort, SORT_ASC, $tickt);
				}
			}
			elseif ($sortType == "ASC")
			{
				if($sortBy == "priority")
				{
					array_multisort($sort, SORT_ASC, $tickt);
				}
				else
				{	
					array_multisort($sort, SORT_DESC, $tickt);
				}
			}
			return $tickt; 
		}
		return $tickt;		
	}

	/**
	* Function to get related tickets by tags
	**/
	public function relatedTag($tickt,$tag)
	{

		//$tag=$data['tagId'];
		$flag=1;
		// Getting post data
	   if( $tag)
	    {
	    	//convert object to array
	    	$tickets = array();
	    	$i = 0;
	    	 foreach ($tickt as $key => $value)
		        {
		            $tickets[$i] = $value;
		            $i++;
		        }
			
			
			for ($i=0; $i < count($tickt); $i++) 
			{ 	
	  			$ticket=Ticket::findOrFail((int)$tickets[$i]['id']);

				// Get Related Tags
				$relatTagIds[] = Ticket::find((int)$tickets[$i]['id'])->TicketTags;
				// var_dump($relatTagIds);
	  	// 		exit();
				for ($j=0; $j < count($relatTagIds[$i]); $j++) 
				{
				  
					if ($relatTagIds[$i][$j]['name'] == $tag) 
					{
					 	$relatTickets[]=$tickets[$i];
					 	$flag=0;

					}
				}				 
			}
			if( $flag == 1 )
				{
					
					$relatTickets=[];
				}

			//convert array to object
			
			
			return $relatTickets;


		 }
		
		 return $tickt;
		 
	}
	
	/**
	* Function to Get available user to assign user to ticket
	**/
	public function takeover(Request $request){

	if($request->ajax()) {
		$users=array();
		$users_tech=User::where('type','tech')->get();
			//file_put_contents("/home/aya/teesst.html", $users_tech);
		for($i=0;$i<count($users_tech);$i++){
		$count=Ticket::where('tech_id',$users_tech[$i]->id)->count();
		if($count<5){
			array_push($users,$users_tech[$i]);
			}
			}}

	echo json_encode($users);

	}
	/**
	* Function to save tech that assign to ticket and make notification
	**/
	public function Save(Request $request){
	// Save notification
	if($request->ajax()) {
	
	$body="this ticket has been taken";
	$user_id=Auth::user()->id;
	$readonly=0;
	$ticket_id=$request->input("ticket_id");
	$notification=new Comment;
	$notification->body=$body;
	$notification->readonly=$readonly;
	$notification->user_id=$user_id;
	$notification->ticket_id=$ticket_id;
	$notification->save();
	//  save tech_id that assigned to the ticket 
	$ticket=Ticket::find($ticket_id);
	$ticket->tech_id=$request->input("tech_id");
	$ticket->save();
	$ticket->fname=Auth::user()->fname;
	$ticket->lname=Auth::user()->lname;
	$ticket->techname=$ticket->tech->fname." ".$ticket->tech->lname;
	$ticket->body="this ticket has been taken";
	}
	echo json_encode($ticket);
	}
	/**
	* Function to get all subject in auto complete
	**/

	public function SearchAllSubject(Request $request){
	// Save notification
$subject=array();
	$type=Auth::user()->type;
	$id=Auth::user()->id;
	if($request->ajax()) {
	if($type == 'admin')
		$subjects=Subject::all()->lists('name');

	if($type == 'regular'){
	$tickets=Ticket::where('user_id','=',$id)->get();
	foreach($tickets as $ticket){
		$subject[]=Subject::where('id','=',$ticket->subject_id)->lists('name')[0];

			}
	$subjects = json_decode(json_encode($subject), FALSE);
			}
	
	if($type == 'tech'){
	$tickets=Ticket::where('tech_id','=',$id)->get();
	foreach($tickets as $ticket){
		$subject[]=Subject::where('id','=',$ticket->subject_id)->lists('name')[0];

			}
	$subjects = json_decode(json_encode($subject), FALSE);
			}
		

	}
	echo json_encode($subjects);
	}
	/**
	* Function to get tickets related to the specific subject in search
	**/

	public function TicketAllSubject(Request $request){
	if($request->ajax()) {
		$subjectName=$request->input("name");
		$targetSubject=Subject::where('name',$subjectName)->first();
		$subjectId=$targetSubject->id;

		$userType=Auth::user()->type;
		$userId=Auth::user()->id;
	
		if($userType=="regular"){
		$targetTickets=Ticket::whereSubject_idAndIs_spam($subjectId,0);
		$targetTickets=$targetTickets->where('user_id',$userId)->get();
		}else{
		$targetTickets=Ticket::whereSubject_idAndIs_spam($subjectId,0)->get();
		}
		}

	//echo json_encode($targetTickets);
		return (string) view('tickets.ajax',compact('targetTickets'));
	}

	/**
	* Function to Search by more than on field in ticket
	**/

	public function AdvancedSearch($Tickets, $data){

	// if($request->ajax()) {
	// 	$priority=$request->input("priority");
	// 	$deadLine=$request->input("enddate");
	// 	$startDate=$request->input("created_at");
	// 	$techId=$request->input("tech_id");
	// 	//$startDate=$startDate+" "+"00:00:00";
	// 	//$deadLine=$deadLine+" "+"23:59:59";
	// 	}

	// 		$userType=Auth::user()->type;
	// 		$userId=Auth::user()->id;
	// 	if ( !$priority && !$techId && !$deadLine && !$startDate  ) 
	//             {   
	// 		if($userType=="regular"){
	// 		$Tickets = Ticket::all()->where('user_id', $userId);
	// 		$Tickets = $Tickets->where('is_spam', "0");
	// 		}else{
	//             	$Tickets = Ticket::all()->where('is_spam', "0"); 
	// 			}
	// 		return (string) view('tickets.adavcedticketsearch',compact('Tickets'));
	//             }

	//             else
	//             {

	// 		if($userType=="regular"){
	// 		$Tickets = Ticket::select('*')->where('user_id', $userId);
	// 		$Tickets = $Tickets->where('is_spam', "0");
	// 		}else{



	// 	            $Tickets =Ticket::select('*')->where('is_spam', "0");
	// 		}


	            if ($data["priority"]) {
	            	$Tickets=$Tickets->where('priority', $data["priority"]);
	            }

	            if ($data["tech"]) {
	            	$Tickets=$Tickets->where('tech_id', $data["tech"]);
	            }
			    if($data["deadLine"] && $data["startDate"]){
		            $Tickets=$Tickets->where('created_at','>=', $data["startDate"]);
					$Tickets=$Tickets->where('deadline','<=', $data["deadLine"]);

				}

				return $Tickets;

		//             $Tickets=$Tickets->get();
		            
		// return (string) view('tickets.adavcedticketsearch',compact('Tickets'));
		//         }  
		
	}


	public function searchTicket(Request $request){
		if($request->ajax()){ 
			$sortType=$request->input('sortType') ;
			$sortBy=$request->input('sortBy');
			$tag=$request->input('tagId');
			$search["priority"] = $request->input("priority");
			$search["deadLine"] = $request->input("endDate");
			$search["startDate"] = $request->input("StartDate");
			$search["tech"] = $request->input("tech");


			if(Auth::user()->type === "admin"){
				$tickets = Ticket::select("*");
			}
			else if(Auth::user()->type === "tech"){
				$tickets = Ticket::select("*")->where('tech_id', $request->user()->id);
			}
			else if(Auth::user()->type === "regular"){
				$tickets = Ticket::select("*")->where('user_id', $request->user()->id);
			}
			if($request->input('name') == "unassigned"){
				$tickets = $tickets->whereNull('tech_id')->where('is_spam', "0");				
			}
			else if($request->input('name') == "open"){
				$tickets = $tickets->where('status', "open")->where('is_spam', "0");
			}
			else if($request->input('name') == "closed"){
				$tickets = $tickets->where('status', "close")->where('is_spam', "0");
			}
			else if($request->input('name') == "all"){
				$tickets = $tickets->where('is_spam', "0");
			}
			else if($request->input('name') == "expired"){
				$tickets = $tickets->where('deadline', '<', Carbon::now())->where('is_spam', "0");
			}
			else if($request->input('name') == "spam"){
				$tickets = $tickets->where('is_spam', "1");
			}
			else if($request->input('name') == "unanswered"){

				$tickets = $tickets->where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
            		->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0 )  THEN 0  ELSE 1 END as c')
                    ->groupBy('tickets.id')
                    ->HAVING("c", "=" , '0' );
			}
			if($request->input('cat')){
				if($request->input('cat') != "all"){
					$tickets = $tickets->where('category_id', $request->input('cat'));
				}
			}
			else if($request->input('sec')){


				$categories = Category::select("id")->where("section_id", $request->input('sec'))->get();

				// $categories = json_decode(json_encode($categories), TRUE);
				// file_put_contents("/home/samah/text.html", $categories[0]);
				$i = 0;
				foreach ($categories as $key => $value) {
					$arr[$i] = $value->id;
					$i++;
				}
				$tickets = $tickets->whereIn('category_id', $arr);
			}
			$tickets= $this->AdvancedSearch ($tickets , $search);
			$ticketPag = $tickets->paginate(5);
			$tickets= $this->relatedTag ( $ticketPag , $tag);
			
			$tickets= $this->sortTicket ( $tickets , $sortBy , $sortType);
			return view("tickets.searchTicket",compact('tickets', 'ticketPag')); 
		}
	}
	
	/**
	* Function to spam ticket
	**/
	public function spamTicket(Request $request)
	{
		if($request->ajax()) {
			$id=$request->input('id');
			$ticket=Ticket::find($id);
			//update that article is spamed
			$ticket->is_spam=1;
			$ticket->save();
			// add the deleted ticket to log table
			$this->addnotification("spam","ticket",$ticket);

			$tickets = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "0")->get();
			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();
	        			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();

	        $data["all"] = $tickets[0]->count;
	        $data["unassigned"] = $unassigned[0]->count;
	        $data["closed"] = $closed[0]->count;
	        $data["open"] = $open[0]->count;
	        $data["expired"] = $expired[0]->count;
	        $data["unanswered"] = count($unanswered);
	        $data["spam"] = $spam[0]->count;

			echo json_encode($data);
		}	
	}


	/**
	* Function to un spam ticket
	**/
	public function unSpamTicket(Request $request)
	{
		if($request->ajax()) {
			$id=$request->input('id');
			$ticket=Ticket::find($id);
			//update that article is spamed
			$ticket->is_spam=0;
			$ticket->save();
			// add the deleted ticket to log table
			$this->addnotification("unspam","ticket",$ticket);

			$tickets = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "0")->get();
			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();
	        			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();

	        $data["all"] = $tickets[0]->count;
	        $data["unassigned"] = $unassigned[0]->count;
	        $data["closed"] = $closed[0]->count;
	        $data["open"] = $open[0]->count;
	        $data["expired"] = $expired[0]->count;
	        $data["unanswered"] = count($unanswered);
	        $data["spam"] = $spam[0]->count;

			echo json_encode($data);
			}	
	}

	/**
	* Function to close ticket
	**/
	public function closeTicket(Request $request)
	{
		if($request->ajax()) {
			$id=$request->input('id');
			$ticket=Ticket::find($id);
			//update that article is status
			$ticket->status="close";
			$ticket->save();
			// save ticket as close status in ticket status table
			$ticketStatus=new TicketStatus;
			$ticketStatus->value='close';
			$ticketStatus->ticket_id=$ticket->id;
			$ticketStatus->save();

			$tickets = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "0")->get();
			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();
	        			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();

	        $data["all"] = $tickets[0]->count;
	        $data["unassigned"] = $unassigned[0]->count;
	        $data["closed"] = $closed[0]->count;
	        $data["open"] = $open[0]->count;
	        $data["expired"] = $expired[0]->count;
	        $data["unanswered"] = count($unanswered);
	        $data["spam"] = $spam[0]->count;

			echo json_encode($data);
		}	
	}


	/**
	* Function to open ticket
	**/
	public function openTicket(Request $request)
	{
		if($request->ajax()) {
			$id=$request->input('id');
			$ticket=Ticket::find($id);
			//update that article is status
			$ticket->status="open";
			$ticket->save();
			// save ticket as open status in ticket status table
			$ticketStatus=new TicketStatus;
			$ticketStatus->value='open';
			$ticketStatus->ticket_id=$ticket->id;
			$ticketStatus->save();

			$tickets = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "0")->get();
			// unassigned tickets except spam tickets
			$unassigned = Ticket::select(DB::raw('count(*) as count'))->whereNull('tech_id')->where('is_spam', "0")->get();
			// closed tickets except spam tickets
			$closed = Ticket::select(DB::raw('count(*) as count'))->where('status', "close")->where('is_spam', "0")->get();
			// open tickets except spam tickets
			$open = Ticket::select(DB::raw('count(*) as count'))->where('status', "open")->where('is_spam', "0")->get();
			// deadline exceeded except spam tickets
			$expired = Ticket::select(DB::raw('count(*) as count'))->where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			// unanswered tickets tickets except spam tickets

			$unanswered = Ticket::where('is_spam', "0")->leftJoin('comments','tickets.id','=','comments.ticket_id')
	            ->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0)  THEN 0  ELSE 1 END as c')
	                    ->groupBy('tickets.id')
	                    ->HAVING("c", "=" , '0' )
	                     ->get();
	        			// spam tickets except spam tickets
			$spam = Ticket::select(DB::raw('count(*) as count'))->where('is_spam', "1")->get();

	        $data["all"] = $tickets[0]->count;
	        $data["unassigned"] = $unassigned[0]->count;
	        $data["closed"] = $closed[0]->count;
	        $data["open"] = $open[0]->count;
	        $data["expired"] = $expired[0]->count;
	        $data["unanswered"] = count($unanswered);
	        $data["spam"] = $spam[0]->count;

			echo json_encode($data);
		}	
	}



	/**
	* Function to add subject for ticket
	**/
	public function addTag(Request $request)
	{
		// Getting post data
		if($request->ajax()) {
			// $data = Input::all();
			$data = $request->input('newtag');
			$tag= new Tag;
			$tag->name=$data;
			$tag->save();
			print_r($tag->id);
		}
	}

	/**
	* Function to Export csv file
	**/
	public function exportCSV()
	{
		$tickets = Ticket::all();

	    // the csv file with the first row
	    $output = implode(",", array('Subject', 'Status', 'Category', 'Creation Date', 'Deadline','Assigned To','Priority'))."\n";

	    foreach ($tickets as $row) {
		// iterate over each tweet and add it to the csv
		$output .=  implode(",", array($row['subject']['name'], $row['status'], $row['category']['name'], 
				$row['created_at'],$row['deadline'],$row['user']['fname']." ".$row['user']['lname'],$row['priority']))."\n"; // append each row
	    }

	    // headers used to make the file "downloadable", we set them manually
	    // since we can't use Laravel's Response::download() function
	    $headers = array(
		'Content-Type' => 'text/csv',
		'Content-Disposition' => 'attachment; filename="tickets.csv"',
		);

	    // our response, this will be equivalent to your download() but
	    // without using a local file
	    return Response::make(rtrim($output, "\n"), 200, $headers);
	}

	public function getCategories(Request $request){
		if($request->ajax()) {
			if(Auth::user()->type === "admin"){
				
				$tickets = Ticket::select("*")->where('is_spam', "0");
				if($request->input('key') == "all"){
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 group by category_id");
				}else if($request->input('key') == "unanswered"){
					$tickets = $tickets->leftJoin('comments','tickets.id','=','comments.ticket_id')
            		->selectRaw('tickets.*, CASE WHEN (   sum(comments.readonly) is null or sum(comments.readonly) = 0 )  THEN 0  ELSE 1 END as c')
                    ->groupBy('tickets.id')
                    ->HAVING("c", "=" , '0' );

                    $categories = DB::select("select count(categories.id) as count, categories.name,t2.id,t2.category_id from categories right join (select tickets.id,tickets.category_id , CASE WHEN (sum(comments.readonly) is null  or sum(comments.readonly) = 0 )  THEN 0  ELSE 1 END as c from tickets left join comments on tickets.id = comments.ticket_id where is_spam = 0 group by tickets.id having c = 0)t2 on t2.category_id= categories.id group by categories.id");

				}else if($request->input('key') == "unassigned"){
					$tickets = $tickets->whereNull('tech_id');
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and tech_id is null group by category_id");
				}else if($request->input('key') == "expired"){
					$tickets = $tickets->where('deadline', '<', Carbon::now());
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and deadline < ? group by category_id",array(Carbon::now()));
				}else if($request->input('key') == "open"){
					$tickets = $tickets->where('status', "open");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and status = 'open' group by category_id");
				}else if($request->input('key') == "closed"){
					$tickets = $tickets->where('status', "close");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and status = 'close' group by category_id");
				}else if($request->input('key') == "spam"){
					$tickets = Ticket::where('is_spam', "1");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 1 group by category_id");
				}
			}
			else if(Auth::user()->type === "tech"){
				$tickets = Ticket::select("*")->where('tech_id', $request->user()->id)->where('is_spam', "0");
				if($request->input('key') == "all"){
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and tech_id = ? group by category_id", array($request->user()->id)); 
					
				}else if($request->input('key') == "open"){
					$tickets = $tickets->where('status', "open");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and tech_id = ? and status = 'open' group by category_id", array($request->user()->id)); 
				
				}else if($request->input('key') == "closed"){
					$tickets = $tickets->where('status', "close");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and tech_id = ? and status = 'close' group by category_id", array($request->user()->id)); 
				
				}
			}
			else if(Auth::user()->type === "regular"){
				$tickets = Ticket::select("*")->where('user_id', $request->user()->id)->where('is_spam', "0");
				if($request->input('key') == "all"){
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and user_id = ? group by category_id", array($request->user()->id));
				
				}else if($request->input('key') == "open"){
					$tickets = $tickets->where('status', "open");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and user_id = ? and status = 'open' group by category_id", array($request->user()->id));
				
				}else if($request->input('key') == "closed"){
					$tickets = $tickets->where('status', "close");
					$categories = DB::select("select tickets.category_id, categories.name,count(*) as count from tickets join categories on categories.id = tickets.category_id where is_spam = 0 and user_id = ? and status = 'close' group by category_id", array($request->user()->id));
				
				}
			}

			$tickets = $tickets->get();
			return view('tickets.categories',compact('categories', 'tickets'));	
		}
	}
}
