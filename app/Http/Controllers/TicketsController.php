<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Auth;
use DB;
use Request;
use App\Subject;
use App\Ticket;
use App\Category;
use App\Section;
use App\User;
use App\Comment;

use App\Tag;
use App\TicketStatus;
use App\Asset;
use App\TicketAsset;

class TicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets=Ticket::all();
		return view('tickets.index',compact('tickets'));
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
	public function store()
	{
		$ticket= new Ticket;
		$ticket->description=Request::get('description');
		$ticket->file=Request::get('file');
		$ticket->category_id=Request::get('category');
		$ticket->subject_id=Request::get('subject');
		$ticket->user_id=Auth::user()->id;
		if(Auth::user()->type === "admin")
		{
			$ticket->priority=Request::get('priority');
			$ticket->deadline=Request::get('deadline');
			$ticket->tech_id=Request::get('tech');
			$ticket->admin_id=Auth::user()->id;
		}else{
			$ticket->tech_id=1;
			$ticket->admin_id=1;
		}
		$id=$ticket->save();
		$tickets=Ticket::all();
		return view('tickets.index',compact('tickets'));
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ticket=  Ticket::find($id);
		$ticket->description=Request::get('description');
		$ticket->priority=Request::get('priority');
		$ticket->file=Request::get('file');
		$ticket->category_id=Request::get('category');
		$ticket->subject_id=Request::get('subject');
		$ticket->user_id=Auth::user()->id;
		if(Auth::user()->type === "admin")
		{
			$ticket->priority=Request::get('priority');
			$ticket->deadline=Request::get('deadline');
			$ticket->tech_id=Request::get('tech');
			$ticket->admin_id=Auth::user()->id;
		}else{
			$ticket->tech_id=1;
			$ticket->admin_id=1;
		}
		$ticket->save();
		return  redirect("/tickets/".$id);
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
	public function addSubject()
	{
		// Getting post data
	    if(Request::ajax()) {
	      // $data = Input::all();
	      $data = Request::input('newsubj');
	      $subject= new Subject;
	      $subject->name=$data;
	      $subject->save();
	      print_r($subject->id);
	    }
	}
	/**
	* Function to update status of ticket
	**/
	public function updatestatus()

	{
		// update ticket_statuses with new state [closed-open]
		if(Request::ajax()) {
		$ticket_id = Request::input("ticket_id");
		$status = Request::input("status");
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
	* Function to Get available user to assign user to ticket
	**/
	public function takeover(){

	if(Request::ajax()) {
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
	public function Save(){
	// Save notification
	if(Request::ajax()) {
	
	$body="this ticket has been taken";
	$user_id=1;
	$readonly=1;
	$ticket_id=Request::input("ticket_id");
	$notification=new Comment;
	$notification->body=$body;
	$notification->readonly=$readonly;
	$notification->user_id=$user_id;
	$notification->ticket_id=$ticket_id;
	$notification->save();
	//  save tech_id that assigned to the ticket 
	$ticket=Ticket::find($ticket_id);
	$ticket->tech_id=Request::input("tech_id");
	$ticket->save();
	}
	echo $body;
	}

	



}
