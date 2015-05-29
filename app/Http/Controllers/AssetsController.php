<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use Request;
use DB;
use Auth;
use App\AssetType;
use App\User;
use App\Asset;
use App\Log;

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
		$asset->admin_id = Auth::user()->id;
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
		$log = new Log;
		$log->type_id = $id;
		$log->action = 'delete';
		$log->type = 'asset';
		$log->user_id = Auth::user()->id;

		$asset = Asset::find($id);

		if($asset->delete()){
			$log->save();
		}
	}

	public function addType()
	{
		if(Request::ajax()) {
			$type = new AssetType;
			$type->name = Request::input('name');
			$type->save();

			$type = DB::table('asset_types')->orderBy('created_at', 'desc')->first();

		    $reply['name'] = $type->name; 
		    $reply['id'] = $type->id;
		    
		    echo json_encode($reply);
		}		
	}


	/**
	 * Show the form for searching for assets.
	 *
	 * @return Response
	 */
	public function search()
	{
		$types = AssetType::all();
		return view("assets.search",compact('types'));
	}

	/**
	 * Search database for assets.
	 *
	 * @return Response
	 */
	public function searchAssets()
	{
         if(Request::ajax())
         {           
            $name = Request::input('name');
            $serialno  = Request::input('serialno');
            $location = Request::input('location');
            $manufacturer= Request::input('manufacturer');
            $assettype_id= Request::input('type');

            //file_put_contents("/home/eman/" . "www.html", $name." ".$serialno." ".$location." ". $manufacturer." ".$assettype_id);

            if ( !$name && !$serialno && !$location && !$manufacturer && !$assettype_id ) 
            {
            	$assets = Asset::all(); 
            	return view("assets.searchAssets",compact('assets'));           	
            }

            // $assets =Asset::where('name', 'like', '%'.$name.'%')
            //    				->where('serialno', 'like', '%'.$serialno.'%')
            //           		->where('location', 'like', '%'.$location.'%')
            //           		->where('manufacturer', 'like', '%'.$manufacturer.'%')
            //           		->where('assettype_id', $assettype_id)
           	// 				->get();

            $assets =Asset::where('name', 'like', '%'.$name.'%');
            $assets=$assets->get();
            

                			


           	return view("assets.searchAssets",compact('assets'));  
            
         }

	}

}

