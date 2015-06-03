<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;
use Illuminate\Http\Request;
//use Request;

class ReportsController extends Controller {

	
	/**
	 * Show the delection/spamming log of tickets, users, assets ,
	 * articles and categories
	 *
	 * @return Response
	 */
	public function logs()
	{
		$logs =Log::all();
		return view('reports.logs',compact('logs'));
	}


	/**
	 * Show the distribution/hour of the opened/closed tickets
	 * within the last 10 days
	 *
	 * @return Response
	 */

	public function distHour()
	{
		
		$date1 = date('Y-m-d h:i:s', time());
		$date2 = date_create($date1);
		date_sub($date2, date_interval_create_from_date_string('10 days'));
		$date2 =  date_format($date2, 'Y-m-d h:i:s');		
		$openedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between ? and ? and status = 'open' group by hour(created_at)",array ( $date2 , $date1) );
		$defaultOpen = '';

		foreach ($openedTickets as $ticket){
			$defaultOpen.=$ticket->hour."_".$ticket->count.":";
		}


		$closedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between ? and ? and status = 'close' group by hour(created_at)",array ( $date2 , $date1) );
		$defaultClose = '';

		
		foreach ($closedTickets as $ticket){
			$defaultClose.=$ticket->hour."_".$ticket->count.":";
		}




		
		return view('reports.perhour',compact('tickets', 'defaultOpen' ,'defaultClose' ));
	}


	/**
	 * Show the distribution/hour of the opened/closed tickets
	 * within a specific range of dates ( called by AJAX )
	 *
	 * @return Response
	 */

	public function ajaxdistHour(Request $request){
        

		if(! $request->ajax()) {
			return;
		}

        $date1= $request->input('date1');
        $date2= $request->input('date2');

		$openedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between ? and ? and status = 'open' group by hour(created_at)",array ( $date1 , $date2) );
		$closedTickets = DB::select("select id ,hour(created_at) as hour , status , count(*) as count from  tickets where created_at between ? and ? and status = 'close' group by hour(created_at)",array ( $date1 , $date2) );
		


		return json_encode(array(
		    'open'  => $openedTickets,
    		'close' => $closedTickets
    	));
   
	}

	/**
	* function to count the tickets in all status
	* count tickets per category
	**/
	public function summary(){

		$inprogressCount=Ticket::whereNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();
		$newCount=Ticket::whereNotNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();
		$resolvedCount=Ticket::where('status','close')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();

		$ticketsPerCategories=Ticket::selectRaw('count(*) as count , category_id ')
									->groupBy('category_id')
									->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
									->get();						
		return view('reports.summary',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'));

	}

	public function summarySearchDate(Request $request)
	{

		// Getting post data
		if($request->ajax()) {
			// $data = Input::all();
			$data = $request->input('date');
			if($data == "month"){

				$inprogressCount=Ticket::whereNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();
				$newCount=Ticket::whereNotNull('tech_id')
										->where('status','open')
										->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
										->count();
				$resolvedCount=Ticket::where('status','close')
										->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
										->count();

				$ticketsPerCategories=Ticket::selectRaw('count(*) as count , category_id ')
											->groupBy('category_id')
											->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
											->get();

				return view('reports.summarySearchMonth',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'));
			}
			
			if($data == "week"){
				$inprogressCount=Ticket::whereNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 week')))
								->count();
				$newCount=Ticket::whereNotNull('tech_id')
										->where('status','open')
										->where('updated_at','>',date('Y-m-d', strtotime('-1 week')))
										->count();
				$resolvedCount=Ticket::where('status','close')
										->where('updated_at','>',date('Y-m-d', strtotime('-1 week')))
										->count();

				$ticketsPerCategories=Ticket::selectRaw('count(*) as count , category_id ')
											->groupBy('category_id')
											->where('updated_at','>',date('Y-m-d', strtotime('-1 week')))
											->get();

				return view('reports.summarySearchWeek',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'));
			}

			if($data == "custom"){
				$startdate=$request->input('startdate');
				$enddate=$request->input('enddate');

				$inprogressCount=Ticket::whereNull('tech_id')
								->where('status','open')
								->where('updated_at','>=',$startdate)
								->where('deadline','<=',$enddate)
								->count();
				$newCount=Ticket::whereNotNull('tech_id')
										->where('status','open')
										->where('updated_at','>=',$startdate)
										->where('deadline','<=',$enddate)
										->count();
				$resolvedCount=Ticket::where('status','close')
										->where('updated_at','>=',$startdate)
										->where('deadline','<=',$enddate)
										->count();

				$ticketsPerCategories=Ticket::selectRaw('count(*) as count , category_id ')
											->groupBy('category_id')
											->where('updated_at','>=',$startdate)
											->where('deadline','<=',$enddate)
											->get();

				return view('reports.summarySearchCustom',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories','startdate','enddate'));


			}

		
		}
	}


}
