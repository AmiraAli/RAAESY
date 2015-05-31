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

class TicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets=Ticket::all();
		//all tickets except spam tickets
		$allTickets = Ticket::where('is_spam', "0")->get();
		// unassigned tickets except spam tickets
		$unassigned = Ticket::whereNull('tech_id')->where('is_spam', "0")->get();
		// closed tickets except spam tickets
		$closed = Ticket::where('status', "close")->where('is_spam', "0")->get();
		// open tickets except spam tickets
		$open = Ticket::where('status', "open")->where('is_spam', "0")->get();
		// deadline exceeded except spam tickets
		$expired = Ticket::where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
		// spam tickets except spam tickets
		$spam = Ticket::where('is_spam', "1")->get();
		// unanswered tickets tickets except spam tickets
		// $unanswered = Ticket::where('status', "close");

		return view('tickets.index',compact('tickets','allTickets','unassigned','open','closed','expired','spam'));
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
			$ticket->file=$request->get('file');
			$ticket->category_id=$request->get('category');
			$ticket->subject_id=$request->get('subject');
			$ticket->user_id=Auth::user()->id;
		if(Auth::user()->type === "admin")
		{
			$ticket->priority=$request->get('priority');
			$ticket->deadline=$request->get('deadline');
			$ticket->tech_id=$request->get('tech');
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
		}else{
			$ticket->tech_id=NULL;
			$ticket->admin_id=NULL;
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
	$ticket=Ticket::findOrFail($id);
	// Get Related Tags
	$relatedTagIds = Ticket::find($id)->TicketTags;
	$relatedTickets=array();
	foreach($relatedTagIds as $relatedTagId){
	$relatedTickets[] = Tag::find($relatedTagId->id)->tickets;
	}

	// Get Related Assests
	$relatedAssets = Ticket::find($id)->TicketAssets;

	// Check status of ticket closed or open
	$checkStatus=TicketStatus::where('ticket_id', $id)->first();

	//get all comments
	$comments=Ticket::find($id)->comments;
	
	//get assigned to and user created it
	//$users=Ticket::find($id)->user;

	return view('tickets.show',compact('ticket','relatedTickets','relatedAssets','checkStatus','comments'));

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
		$users=array();
		$users_tech=User::where('type','tech')->get();
		for($i=0;$i<count($users_tech);$i++){
			$count=Ticket::where('tech_id',$users_tech[$i]->id)->count();
			if($count<5){
				array_push($users,$users_tech[$i]);
			}
		}
		return view('tickets.edit',compact('ticket','subjects','categories','sections','users'));
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
		$ticket->file=$request->get('file');
		$ticket->category_id=$request->get('category');
		$ticket->subject_id=$request->get('subject');
		$ticket->user_id=Auth::user()->id;

		if(Auth::user()->type === "admin")
		{
			$ticket->priority=$request->get('priority');
			$ticket->deadline=$request->get('deadline');
			$ticket->tech_id=$request->get('tech');
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
		$ticket->delete();
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
		$ticketStatus=TicketStatus::where('ticket_id', $ticket_id)->first();
		$ticketStatus->value=$status;
		$ticketStatus->save();

		// save notification
		$readonly=1;
		if($status=='close')
		$body="this ticket has be closed";
		if($status=='open')
		$body="this ticket has been re-opened";	
		$notify= new Comment;
		$notify->body=$body;
		$notify->readonly=intval($readonly);
		$notify->ticket_id=intval($ticket_id);
		$notify->user_id=intval(2);
		$notify->save();
		file_put_contents("/home/aya/teesst.html", $notify);

	}

	/**
	* Function to sort tickets
	**/
	public function sortTicket()
	{
		$data=Request::input();
		$tickt= json_decode(json_encode($data['data']),TRUE);
		$sortBy=$data['sortType'];
	           // var_dump($tickt[0]['id']);

		// Getting post data
	  if(Request::ajax())
	    {
	    	$tickets = array();
	        foreach ($tickt[0] as $key => $value)
	        {
	            $tickets[$key] = $value;
	        }
	    	//file_put_contents("/home/eman/"."aaaaa.html",(array)$tickets[0]);

			function cmp($a, $b)
			{
				file_put_contents("/home/eman/"."gtt.html", "kkkk");
			    return strcmp($a->id, $b->id);
			}
			//$tickets=(array)$tickets;

			 usort($tickets, 'cmp');


			 //file_put_contents("/home/eman/"."aaaaa.html", "ooooo");

			return view("tickets.sortTicket",compact('tickets')); 

		 }
	}
	/**
	* Function to Get available user to assign user to ticket
	**/
	public function takeover(Request $request){

	if($request->ajax()) {
		$users=array();
		$users_tech=User::where('type','tech')->get();
			file_put_contents("/home/aya/teesst.html", $users_tech);
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
	$user_id=1;
	$readonly=1;
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
	}
	echo $body;
	}


	public function SearchAllSubject(Request $request){
	// Save notification
	if($request->ajax()) {
	$subjects=Subject::all()->lists('name');

	}
	echo json_encode($subjects);
	}
	//public function TicketAllSubject(Request $request){
	//if($request->ajax()) {
	//	$subjectName=$request->input("name");
	//	$targetSubject=Subject::where('name',$subjectName)->first();
	//	$subjectId=$targetSubject->id;

	//	}



	//}

	public function searchTicket(Request $request){
		if($request->ajax()){  
			if($request->input('name') == "unassigned"){
				$tickets = Ticket::whereNull('tech_id')->where('is_spam', "0")->get();				
			}
			else if($request->input('name') == "open"){
				$tickets = Ticket::where('status', "open")->where('is_spam', "0")->get();
			}
			else if($request->input('name') == "closed"){
				$tickets = Ticket::where('status', "close")->where('is_spam', "0")->get();
			}
			else if($request->input('name') == "all"){
				$tickets = Ticket::where('is_spam', "0")->get();
			}
			else if($request->input('name') == "expired"){
				$tickets = Ticket::where('deadline', '<', Carbon::now())->where('is_spam', "0")->get();
			}
			else if($request->input('name') == "spam"){
				$tickets = Ticket::where('is_spam', "1")->get();
			}
			else if($request->input('name') == "unanswered"){

			}
			return view("tickets.searchTicket",compact('tickets')); 
		}
	}

}
