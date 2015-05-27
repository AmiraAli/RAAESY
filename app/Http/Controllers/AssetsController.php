<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use Request;

use App\AssetType;
use App\User;
use App\Asset;

class AssetsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$assets = Asset::all();
		return view("assets.index",compact('assets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$types = AssetType::all();
		$users = User::all();
		return view("assets.create",compact('types','users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$asset = new Asset;
		
		$asset->name = Request::get('name');
		$asset->serialno = Request::get('serialno');
		$asset->location = Request::get('location');
		$asset->comment = Request::get('comment');
		$asset->assettype_id = Request::get('assettype_id');
		$asset->user_id = Request::get('user_id');
		$asset->manufacturer = Request::get('manufacturer');
		
		$asset->save();
		
		return redirect('/assets');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$asset = Asset::find($id);
   		return view('assets.show',compact('asset'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$asset = Asset::find($id);
		$types = AssetType::all();
		$users = User::all();
	
		return view("assets.edit",compact('asset', 'types', 'users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$asset = Asset::find($id);

		$asset->name = Request::get('name');
		$asset->serialno = Request::get('serialno');
		$asset->location = Request::get('location');
		$asset->comment = Request::get('comment');
		$asset->manufacturer = Request::get('manufacturer');
		$asset->assettype_id = Request::get('assettype_id');
		$asset->user_id = Request::get('user_id');

		$asset->save();

		return redirect("assets");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Asset::find($id)->delete();
	}

}
