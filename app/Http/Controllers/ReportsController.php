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
	* function to render to view of all reports
	**/
	public function index()
	{
		return view('reports.index');
	}
	
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
		
		$date1 = date('Y-m-d H:i:s', time());
		$date2 = date_create($date1);
		date_sub($date2, date_interval_create_from_date_string('10 days'));
		$date2 =  date_format($date2, 'Y-m-d H:i:s');		
		$openedTickets = DB::select("select id ,hour(created_at) as hour ,  count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'open' group by hour(created_at)",array ( $date2 , $date1) );
		$defaultOpen = '';

		foreach ($openedTickets as $ticket){
			$defaultOpen.=$ticket->hour."_".$ticket->count.":";
		}


		$closedTickets = DB::select("select id ,hour(created_at) as hour  , count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'close' group by hour(created_at)",array ( $date2 , $date1) );
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

	public function ajaxdistHour(){
        

		if(!Request::ajax()) {
			return;
		}

        $date1= Request::input('date1');
        $date2= Request::input('date2');

		$openedTickets = DB::select("select id ,hour(created_at) as hour ,  count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'open' group by hour(created_at)",array ( $date1 , $date2) );
		$closedTickets = DB::select("select id ,hour(created_at) as hour ,  count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'close' group by hour(created_at)",array ( $date1 , $date2) );
		


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

		$tickets=Ticket::where('updated_at','>=',date('Y-m-d', strtotime('-1 month')))->get();
						
		return view('reports.summary',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'
												,'tickets'));

	}

	public function summarySearchDate()
	{

		// Getting post data
		if(Request::ajax()) {
			// $data = Input::all();
			$data = Request::input('date');
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

				$tickets=Ticket::where('updated_at','>=',date('Y-m-d', strtotime('-1 month')))->get();

				return view('reports.summarySearchMonth',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'
												,'tickets'));
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

				$tickets=Ticket::where('updated_at','>=',date('Y-m-d', strtotime('-1 week')))->get();

				return view('reports.summarySearchWeek',compact('inprogressCount','newCount'
												,'resolvedCount','ticketsPerCategories'
												,'tickets'));
			}

			if($data == "custom"){
				$startdate=Request::input('startdate');
				$enddate=Request::input('enddate');

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

				$tickets=Ticket::where('updated_at','>=',$startdate)
								->where('deadline','<=',$enddate)
								->get();

				return view('reports.summarySearchCustom',compact('inprogressCount','newCount'
																,'resolvedCount','ticketsPerCategories'
																,'startdate','enddate','tickets'));


			}

		
		}
	}

	public function technicianStatistics()
	{

		return view('reports.technicianStatistics',compact('technicians'));

	}


	public function technicianStatisticsSearch()
	{
		
			$startDate = Request::get('from');
			$endDate = Request::get('to');

	}


}
