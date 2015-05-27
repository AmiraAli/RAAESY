<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Subject;
use App\Ticket;
use App\Category;
use App\Section;
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
		return view('tickets.create',compact('subjects','categories','sections'));
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
		$ticket->priority=Request::get('priority');
		$ticket->file=Request::get('file');
		$ticket->category_id=Request::get('category');
		$ticket->subject_id=Request::get('subject');
		$ticket->createddate=date('Y-m-d H:i:s');
		$ticket->user_id=1;
		$ticket->tech_id=1;
		$ticket->admin_id=1;
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
		return view('tickets.edit',compact('ticket','subjects','categories','sections'));
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
		$ticket->createddate=date('Y-m-d H:i:s');
		$ticket->user_id=1;
		$ticket->tech_id=1;
		$ticket->admin_id=1;
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

}
