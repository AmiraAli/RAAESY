<?php namespace App\Http\Controllers;

//use Illuminate\Http\Request;
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
use App\Tag;
use App\TicketTag;

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
	//Request $request
	public function store()
	{
		#$this->validate($request,['description'=>'required','file'=>'required']);

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

			$ticket->save();

			//insert into table ticket_tags each tag of this ticket
				$tags=Request::get('tagValues');
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
			$ticket->tech_id=1;
			$ticket->admin_id=1;

			$ticket->save();
		}
		
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
		return view('tickets.show',compact('ticket'));
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

			$ticket->save();

			// check if tags of ticket is changed or not
			$tags=Request::get('tagValues');
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
			$ticket->tech_id=1;
			$ticket->admin_id=1;

			$ticket->save();
		}
		
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
	* Function to get all tags by autocomplete
	**/
	public function getTags()
	{
		// Getting post data
	    if(Request::ajax()) {
	      // $data = Input::all();
	      $data = Request::input('q');
	      $tags=Tag::select('name')->where('name','like',"%".$data.'%')->get();
	      // file_put_contents("/home/amira/test.html", $tags);
	      echo json_encode($tags);
	    }
	}
	
}
