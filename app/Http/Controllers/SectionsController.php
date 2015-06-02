<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Section;
use Request;
use App\Category;

class SectionsController extends Controller {

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
		$section = new Section;
		$section->name = Request::get('name');
		$section->save();

		return redirect('/sections');
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
		$section->delete();
	}

}
