<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Request;
use DB;
use Auth;
use App\AssetType;
use App\User;
use App\Asset;
use App\Log;
use Validator;

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
	 * Storaae a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
	        'name' => 'required',
	        'manufacturer' => 'required',
	        'serialno' => 'required|unique:assets',
	        'location' => 'required'
    	]);

		$asset = new Asset;
		
		$asset->name = $request->get('name');
		$asset->serialno = $request->get('serialno');
		$asset->location = $request->get('location');
		$asset->comment = $request->get('comment');
		$asset->assettype_id = $request->get('assettype_id');
		$asset->user_id = $request->get('user_id');
		$asset->admin_id = Auth::user()->id;
		$asset->manufacturer = $request->get('manufacturer');
		
		$asset->save();
		return redirect("assets");
			
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
	public function update($id, Request $request)
	{
		$this->validate($request, [
	        'name' => 'required',
	        'manufacturer' => 'required',
	        'serialno' => 'required',
	        'location' => 'required'
    	]);
		$asset = Asset::find($id);

		$asset->name = $request->get('name');
		$asset->serialno = $request->get('serialno');
		$asset->location = $request->get('location');
		$asset->comment = $request->get('comment');
		$asset->manufacturer = $request->get('manufacturer');
		$asset->assettype_id = $request->get('assettype_id');
		$asset->user_id = $request->get('user_id');

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

	public function addType(Request $request)
	{
		if($request->ajax()) {
			$type = new AssetType;
			$type->name = $request->input('name');
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
	public function search(Request $request)
	{
		$types = AssetType::all();
		return view("assets.search",compact('types'));
	}

	/**
	 * Search database for assets.
	 *
	 * @return Response
	 */
	public function searchAssets(Request $request)
	{
         if($request->ajax())
         {           
            $name = $request->input('name');
            $serialno  = $request->input('serialno');
            $location = $request->input('location');
            $manufacturer= $request->input('manufacturer');
            $assettype_id= $request->input('type');

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