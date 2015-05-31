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
use App\Log;
use Mail;


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
	public function index()
	{
		$tickets=Ticket::all();
		$myTickets = Ticket::where('tech_id', Auth::user()->id)->get();
		$unassignedTickets = Ticket::whereNull('tech_id')->get();
		// $closed = Ticket::where('status', "close")->get();
		$technicals = User::where('type', 'tech')->get();
		// $open = Ticket::where('status', "open")->get();
		// $statuses=TicketStatus::all();
		// $closed = TicketStatus::where('value', "close")->get();
		// $closed = TicketStatus::where('value', "close")->get();

		return view('tickets.index',compact('tickets','myTickets','unassignedTickets','technicals'));



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

			// check if assigned to technical will send mail to him

			if($request->get('tech')){

				$ticket_array=json_decode(json_encode($ticket), true);
				$ticket_array['verification_code']  = $ticket->verification_code;
				$ticket_array['tech_fname']=$ticket->tech->fname;
				$ticket_array['tech_lname']=$ticket->tech->lname;
				$ticket_array['tech_email']=$ticket->tech->email;
				$ticket_array['subj_name']=$ticket->subject->name;

				Mail::send('emails.techassigned', $ticket_array, function($message) use ($ticket_array)
            	{
	                $message->from('yoyo80884@gmail.com', "RAAESY");
	                $message->subject("RAAESY");
	                $message->to($ticket_array['tech_email']);
            	});
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
	$ticket=Ticket::find($id);
	// Get Related Tags

	$relatedTagIds = Ticket::find($id)->TicketTags;

	$relatedIds=array();
	foreach($relatedTagIds as $relatedTagId){
	$relatedIds[]=$relatedTagId->id;
	}

	$relatedTickets=Ticket::join('ticket_tags', 'tickets.id', '=', 'ticket_tags.ticket_id')
	->whereIn('ticket_tags.tag_id',$relatedIds)->groupBy('tickets.id')->get();

	file_put_contents("/home/aya/teesst.html", $relatedTickets);

	// Get Related Assests
	$relatedAssets = Ticket::find($id)->TicketAssets;

	//get all comments
	$comments=Ticket::find($id)->comments;

	// Check status of ticket closed or open
	$checkStatus=TicketStatus::where('ticket_id', $id)->first();

	

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

			$prev_tech_id=$ticket->tech_id;

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

			// check if assigned to another technical will send mail to him

			if($request->get('tech') != $prev_tech_id){

				$ticket_array=json_decode(json_encode($ticket), true);
				$ticket_array['verification_code']  = $ticket->verification_code;
				$ticket_array['tech_fname']=$ticket->tech->fname;
				$ticket_array['tech_lname']=$ticket->tech->lname;
				$ticket_array['tech_email']=$ticket->tech->email;
				$ticket_array['subj_name']=$ticket->subject->name;

				Mail::send('emails.techassigned', $ticket_array, function($message) use ($ticket_array)
            	{
	                $message->from('yoyo80884@gmail.com', "RAAESY");
	                $message->subject("RAAESY");
	                $message->to($ticket_array['tech_email']);
            	});
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

		// add the deleted ticket to log table
		$this->addnotification("delete","ticket",$ticket);

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
	$ticket->body="this ticket has been taken";
	}
	echo json_encode($ticket);
	}
	/**
	* Function to get all subject in auto complete
	**/

	public function SearchAllSubject(Request $request){
	// Save notification
	if($request->ajax()) {
	$subjects=Subject::all()->lists('name');

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
		$targetTickets=Ticket::where('subject_id',$subjectId)->get();
		}

	//echo json_encode($targetTickets);
		return (string) view('tickets.ajax',compact('targetTickets'));
	}

	/**
	* Function to Search by more than on field in ticket
	**/

	public function AdvancedSearch(Request $request){
	if($request->ajax()) {
		$priority=$request->input("priority");
		$deadLine=$request->input("enddate");
		$startDate=$request->input("created_at");
		$techId=$request->input("tech_id");
		$startDate=$startDate+" "+"00:00:00";
		$deadLine=$deadLine+" "+"23:59:59";
		}

	if ( !$priority && !$techId && !$deadLine && !$startDate  ) 
            {
            	$Tickets = Ticket::all(); 
		return (string) view('tickets.adavcedticketsearch',compact('Tickets'));
            }

            else
            {
	            $Tickets =Ticket::select('*');

	            if ($priority) {
	            	$Tickets=$Tickets->where('priority',$priority);
	            }

	            if ($techId) {
	            	$Tickets=$Tickets->where('tech_id',$techId);
	            }
		    if($deadLine and $startDate){
	            	$Tickets=$Tickets->where('updated_at','>=',$startDate);
			$Tickets=$Tickets->where('deadline','<=',$deadLine);
			}

	            $Tickets=$Tickets->get();
	            
	return (string) view('tickets.adavcedticketsearch',compact('Tickets'));
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
			}	
	}
}
