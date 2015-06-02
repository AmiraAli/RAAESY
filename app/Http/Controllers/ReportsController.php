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
		return view('reports.perhour');
	}

	public function ticketsPerTime()
	{
		$from = date('Y-m-d', strtotime('-2 day'));
		$to = date('Y-m-d', strtotime('+0 day'));
		$tickets = Ticket::select(DB::raw('count(*) as ticketCount,created_at'))->whereBetween('created_at', [$from, $to])->groupBy(DB::raw('DATE(created_at)'))->get();	
// // 		$datetime1 = date_create(date('Y-m-d', strtotime('-2 day')));
// // $datetime2 = date_create(date('Y-m-d', strtotime('+0 day')));
// 		$datetime1 = date_create('2009-10-11');
// $datetime2 = date_create('2009-10-13');
// 		$interval = date_diff($datetime1, $datetime2);
// 			$interval->format('%R%a days');
		// for ($i=0; $i < count($tickt); $i++){

		// }
			
		return view('reports.ticketsPerTime', compact('tickets'));
	}

	public function prepareTickets()
	{
		file_put_contents("/home/samah/teesst.html", "aaaaaaaaaaa");
		// if( $request->ajax() ) {
			// $unit = $request->input("unit");
			// $from = $request->input("from");
			// $to = $request->input("to");

			// $tickets = Ticket::select('count(created_at)','created_at')->whereBetween('created_at', [$from, $to])->groupBy('date(created_at)')->get();
			echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
			// echo json_encode($tickets);
		// }
	}
}
