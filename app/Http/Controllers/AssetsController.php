<?php namespace App\Http\Controllers;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Request;
use DB;
use Auth;
use App\AssetType;
use App\User;
use App\Asset;
use App\TicketAsset;
use App\Log;
use Validator;

class AssetsController extends Controller {

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
		$assets = Asset::paginate(5);
		$types = AssetType::all();
		return view("assets.index",compact('assets','types'));
	}


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
		$notification->name = $model_obj->manufacturer." ".$model_obj->name;
		$notification->type_id = $model_obj->id;
		$notification->user_id = Auth::user()->id;
		$notification->save();

	}

	/*
	 * Headers used to export files to CSV
	 */
	private function getCSVHeaders(){

		return array('Pragma' =>  'public',
			'Expires' =>  '0' , 
			'Cache-Control' =>  'must-revalidate, post-check=0, pre-check=0' , 
			'Content-Description' =>  'File Transfer' , 
			'Content-Type' =>  'text/csv' , 
			'Content-Disposition' => 'attachment; filename=export.csv;' , 
			'Content-Transfer-Encoding' =>  'binary' ,

		);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$types = AssetType::all();
		$users = User::where('type' ,'regular')->get();
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
		
		$asset->name = trim($request->get('name'));
		$asset->serialno = trim($request->get('serialno'));
		$asset->location = trim($request->get('location'));
		$asset->comment = trim($request->get('comment'));
		$asset->assettype_id = $request->get('assettype_id');
		$asset->user_id = $request->get('user_id');
		$asset->admin_id = Auth::user()->id;
		$asset->manufacturer = trim($request->get('manufacturer'));
		
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
		if (empty($asset)){
			return view('errors.404');
		}
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
		if (empty($asset)){
			return view('errors.404');
		}
		$types = AssetType::all();
		$users = User::where('type','regular')->get();
	
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

		$asset->name = trim($request->get('name'));
		$asset->serialno = trim($request->get('serialno'));
		$asset->location = trim($request->get('location'));
		$asset->comment = trim($request->get('comment'));
		$asset->manufacturer = trim($request->get('manufacturer'));
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
		$asset = Asset::find($id);

		if($asset->delete()){
			$this->addnotification("delete"  , "asset" , $asset );
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

            //file_put_contents("/home/eman/"."www.html", $assettype_id);

            if ( !$name && !$serialno && !$location && !$manufacturer && !$assettype_id ) 
            {
            	$assets = Asset::paginate(5);
            	return view("assets.searchAssets",compact('assets'));           	
            }

            else
            {
	            $assets =Asset::select('*');

	            if ($name) {
	            	$assets=$assets->where('name', 'like', '%'.$name.'%');
	            }

	            if ($location) {
	            	$assets=$assets->where('location', 'like', '%'.$location.'%');
	            }

	            if ($manufacturer) {
	            	$assets=$assets->where('manufacturer', 'like', '%'.$manufacturer.'%');
	            }

	            if ($assettype_id) {
	            	$assets=$assets->where('assettype_id', $assettype_id);
	            }

	            if ($serialno) {
	            	$assets=$assets->where('serialno', 'like', '%'.$serialno.'%');
	            }

	            $assets=$assets->paginate(5);
	            
	           	return view("assets.searchAssets",compact('assets'));
	        }  
            
         }

	}
	/**
	 *This function is to select all assets to add assets to ticket
	 *
	 * 
	 * @return jsonobject
	 */
	public function AddAssets()
	{	
			$assets=Asset::all();



			echo json_encode($assets);	

	}
	/**
	 *This function is add asset to ticket
	 *
	 * 
	 * @return jsonobject
	 */
	public function SaveAssets(Request $request)
	{	if($request->ajax()) {
			$ticketasset=new TicketAsset;
			$ticketasset->asset_id=$request->input("asset_id");
			$ticketasset->ticket_id=intval($request->input("ticket_id"));

			$ticketasset->save();	

		$asset=Asset::find($request->input("asset_id"));
		$asset->ticket_id=intval($request->input("ticket_id"));
			}
		echo json_encode($asset);
	}


	/**
	 *This function is to import Asset to csv
	 *
	 * 
	 * @return jsonobject
	 */



	public function importToCsv()
	{


	$assests = Asset::all();

	    // the csv file with the first row
		$output = chr(0xEF) . chr(0xBB) . chr(0xBF) ;
	    $output .= implode(",", array('id', 'Model', 'Manufacturer', 'Type', 'Serial Number','Belongs To','Location'))."\n";

	    foreach ($assests as $row) {
		// iterate over each tweet and add it to the csv
		$output .=  implode(",", array($row['id'], $row['name'], $row['manufacturer'], 
				$row['assettype']['name'],$row['serialno'],$row['user']['fname']." ".$row['user']['lname'],$row		   						['location']))."\n"; // append each row
	    }

	    // headers used to make the file "downloadable"
	    $headers = $this->getCSVHeaders();

	    // this will be equivalent to your download() but
	    // without using a local file
	    return Response::make(rtrim($output, "\n"), 200, $headers);
	}

	public function removeAsset(Request $request)
	{	
		if($request->ajax()) {

			$ticketId = $request->input('ticket_id');
			$assetId = $request->input('asset_id');
			$relatedAsset = TicketAsset::where('ticket_id',$ticketId)->where('asset_id',$assetId)->delete();
		}
	}
		
}


