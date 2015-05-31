<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\Ticket;
use App\Comment;
use Auth;
use App\User;
use Mail;
class CommentsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($ticket_id)
	{
 		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($ticket_id)
	{
		
		$comment = new Comment;
	    	$comment->body = Request::get('body');
	    	$comment->ticket_id = $ticket_id;
	    	$comment->user_id = Auth::user()->id;
	    	$comment->readonly=1;
	    	$comment->save();
	    	$comment->fname = Auth::user()->fname;
		$comment->lname = Auth::user()->lname;

		//$data=array('comment'=>$comment->body,
			 //  );
		//Mail::send('emails.comment', $data, function($message) use ($data)
            //{
              //  $message->from('yoyo80884@gmail.com', "Site name");
               // $message->subject("Welcome to site name");
                //$message->to('yoyo_tok8@yahoo.com');
            //});
	    	echo json_encode($comment);
    
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($ticket_id , $comment_id)
	{
		

		$comment = Comment::findOrFail($comment_id);
		$comment->body = Request::get('body');
		$comment->save();
		$comment->fname=Auth::user()->fname;
		$comment->lname=Auth::user()->lname;
		echo json_encode($comment);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($ticket_id , $comment_id)
	{
		$comment = Comment::findOrFail($comment_id);
		$comment->delete();

	}

}
