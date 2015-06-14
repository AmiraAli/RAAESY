<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Section;
use App\Log;
use Auth;

class CategoriesController extends Controller {

	

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
		$notification->name = $model_obj->name;
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
		$categories = Category:: all();

		return view('categories.index',compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$sections = Section:: all();
		return view('categories.create',compact('sections'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = Category:: findOrFail($id);

		return view('categories.show',compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = Category::find($id);
		
		return (string)view('categories.edit',compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Category::where('name','=',Request::get('name'))->exists()){
			return "NOT DONE";
		}
		$category = Category::find($id);
		$category->name = Request::get('name');
		$category->save();

		return (string)view('categories.editcat',compact('category'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$category = Category::find($id);

		//add notification wher article deleted
		$this->addnotification("delete"  , "category" , $category );
		
		$category->delete();
	}


	public function createajax()
	{
		$sectionid=Request::input('sectionid');
		return view('categories.new',compact('sectionid'));
	}
	public function saveCategory()
	{
		if(Category::where('name', '=', Request::input('categoryname'))->exists()){	
				return "not done";
		}else{
			$category = new Category;
			$category->name = Request::input('categoryname');
			$category->section_id= Request::input('sectionid');
			$category->save();
			return view('categories.ajaxcreate',compact('category'));
		}
	}

}
