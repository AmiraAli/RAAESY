<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;

use Illuminate\Http\Request;

class ReportsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function logs()
	{
		$logs =Log::all();
		return view('reports.logs',compact('logs'));
	}


	public function distHour()
	{
		
		//echo $date."<br/>";
		//$date =  time();
		//$date2 = date('Y-m-d h:i:s', time());
		$date1 = date('Y-m-d h:i:s', time());
		$date2 = date_create($date1);
		date_sub($date2, date_interval_create_from_date_string('10 days'));
		echo $date1;
		echo "<br/>";
		$date2 =  date_format($date2, 'Y-m-d h:i:s');
		echo $date2;
		

			
		
//		$tickets=Ticket::selectRaw('hour(created_at), count(*)')->where('status','=','open')->whereBetween('created_at', ["$date2", "$date1 group by hour(created_at) "])->get();
													// ->groupBy('created_at')->get();

	
	$tickets = DB::select("select id ,hour(created_at) , status , count(*) as c from  tickets where created_at between '2015-05-20' and '2015-06-3' group by hour(created_at)");
	$yy = "ya raab";
		/*foreach ($results as $res){
			echo $res->c;
		}*/
		
		return view('reports.perhour',compact('tickets', 'yy'));
	}


	// public function ajaxdistHour(){

	// 	$tickets=Ticket::where
	// }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
