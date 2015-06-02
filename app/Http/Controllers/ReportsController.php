<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;
//use Illuminate\Http\Request;
use Request;

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
		
		$date1 = date('Y-m-d h:i:s', time());
		$date2 = date_create($date1);
		date_sub($date2, date_interval_create_from_date_string('10 days'));
		$date2 =  date_format($date2, 'Y-m-d h:i:s');		
		$openedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between '$date2' and '$date1' and status = 'open' group by hour(created_at)");
		$defaultOpen = '';

		foreach ($openedTickets as $ticket){
			$defaultOpen.=$ticket->hour."_".$ticket->count.":";
		}


		$closedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between '$date2' and '$date1' and status = 'close' group by hour(created_at)");
		$defaultClose = '';

		
		foreach ($closedTickets as $ticket){
			$defaultClose.=$ticket->hour."_".$ticket->count.":";
		}




		
		return view('reports.perhour',compact('tickets', 'defaultOpen' ,'defaultClose' ));
	}


	public function ajaxdistHour(){
        

        $date1=Request::get('date1');
        $date2=Request::get('date2');

        //echo $date1;
        //echo $date2;
        //exit();1
/*
        $date1 = '2015-06-01 00:00:00';
        $date2= '2015-06-02 23:59:59';*/

		$openedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between '$date1' and '$date2' and status = 'open' group by hour(created_at)");
		$closedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between '$date1' and '$date2' and status = 'close' group by hour(created_at)");
		


		return json_encode(array(
		    'open'  => $openedTickets,
    		'close' => $closedTickets
    	));
   
	}


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

	public function SummaryCategories(){
		$ticketsPerCategories=Ticket::selectRaw('count(*) as tg , category_id ')->groupBy('category_id')
        ->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))->get();


		

		return view('reports.summaries',compact('ticketsPerCategories'));

	}
}
