<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Section;
use App\Log;
use Request;
use App\Category;
use Auth;



class SectionsController extends Controller {

	

	/**
	 * Notify when category is spam/delete (called by AJAX).
	 *
	 * @param  object  $model_obj , string action
	 * @return Response
	 */


	private function addnotification($action , $type , $model_obj ){

		$notification = new Log();
		$notification->type = $type ;
		$notification->action = $action;
		$notification->name = $model_obj->name;
		$notification->type_id = $model_obj['id'];
		$notification->user_id = Auth::user()->id;
		$notification->save();

	}

	public function __construct()
	{
		$this->middleware('auth');
		if (Auth::check()){
			if (Auth::User()->type !="admin"){								
				Redirect('error')->send();

			}
		}
	}
	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sections = Section:: all();
		$categories= Category::all();
		return view('sections.index',compact('sections','categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sections.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		
		if(Section::where('name', '=', Request::get('name'))->exists()){	
				return "not done";
		}else{
			$section = new Section;
			$section->name = Request::get('name');
			$section->save();
			return view('sections.ajaxcreate',compact('section'));
	
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
		$section = Section:: findOrFail($id);

		return view('sections.show',compact('section'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$section = Section:: find($id);

		return (string)view('sections.edit',compact('section'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Section::where('name','=',Request::get('name'))->exists()){
			return "NOT DONE";
		}
		$section = Section:: find($id);
		$section->name = Request::get('name');
		$section->save();

		return (string)view('sections.editsave',compact('section'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$section = Section:: find($id);

		$categories=Category::where('section_id','=',$id)->get();

		for ($i=0; $i <count($categories); $i++) {
			//add notification wher article deleted
			$this->addnotification("delete"  , "category" , $categories[$i] );
		}
		$section->delete();
	}

}
