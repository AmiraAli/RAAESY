<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;
use App\TicketStatus;
use App\User;


//use Illuminate\Http\Request;
use Request;

class ReportsController extends Controller {

	
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

	public function technicianStatistics()
	{
		$technicians = DB::select("select count(IF(tickets.status = 'close', 1, null)) as closed, count(IF(tickets.status = 'open', 1, null)) as open, users.fname, users.lname, users.id from users left join tickets on users.id = tickets.tech_id where users.type = 'tech' group by tickets.tech_id");
		return view('reports.technicianStatistics',compact('technicians'));
	}
	public function technicianStatisticsSearch()
	{
		
			$startDate = Request::get('from');
			$endDate = Request::get('to');
			$technicians = DB::select("select count(IF(tickets.status = 'close', 1, null)) as closed, count(IF(tickets.status = 'open', 1, null)) as open, users.fname, users.lname, users.id from users left join tickets on users.id = tickets.tech_id where users.type = 'tech' group by tickets.tech_id");
		
	}

	public function ticketsPerTime()
	{
		$from = date('Y-m-d', strtotime('-2 day'));
		$to = date('Y-m-d', strtotime('+1 day'));
		$tickets = Ticket::select(DB::raw('count(*) as ticketCount,DATE(created_at) as date'))->whereBetween('created_at', [$from, $to])->groupBy(DB::raw('DATE(created_at)'))->get();	
		// $closed = TicketStatus::select(DB::raw('count(IF(ticket_stauses.value = 'close', 1, null)) as ticketCount,DATE(created_at) as date'))->whereBetween('created_at', [$from, $to])->groupBy(DB::raw('DATE(created_at)'))->get();	

// // 		$datetime1 = date_create(date('Y-m-d', strtotime('-2 day')));
// // $datetime2 = date_create(date('Y-m-d', strtotime('+0 day')));
// 		$datetime1 = date_create('2009-10-11');
// $datetime2 = date_create('2009-10-13');
// 		$interval = date_diff($datetime1, $datetime2);
// 			$interval->format('%R%a days');
		
			$points[0] = date('Y-m-d', strtotime('-2 day'));
			$points[1] = date('Y-m-d', strtotime('-1 day'));
			$points[2] = date('Y-m-d', strtotime('+0 day'));
			$f = 0;
			foreach ($points as $point) {
				foreach ($tickets as $ticket) {					
					if(strtotime($ticket->date) == strtotime($point)){
						$createdTickets[] = $ticket->ticketCount;
						$f = 1;
					}
				}
				if($f == 0){
					$createdTickets[] = 0;
				}
				$f = 0;
			}			
		return view('reports.ticketsPerTime', compact('points','createdTickets'));
	}

	public function prepareTickets()
	{
		if( Request::ajax() ) {
			$unit = Request::input("unit");
			$from = Request::input("from");
			$to = Request::input("to");
			$tomorrow = date('Y-m-d',strtotime($to . "+1 days"));

			if($unit == "day"){
				
				$tickets = Ticket::select(DB::raw('count(*) as ticketCount,DATE(created_at) as date'))->whereBetween('created_at', [$from, $tomorrow])->groupBy(DB::raw('DATE(created_at)'))->get();	

			     $datediff = strtotime($to) - strtotime($from);
			     $timeDiff = floor($datediff/(60*60*24)) + 1;
			     $f = 0;
			     for($i = 0; $i < $timeDiff; $i++){
			     	$points[$i] = date('Y-m-d',strtotime($from . "+".$i ."days"));
				     	foreach ($tickets as $ticket) {			
							if(strtotime($ticket->date) == strtotime($points[$i])){
								$createdTickets[] = $ticket->ticketCount;
								$f = 1;
							}
						}
						if($f == 0){
							$createdTickets[] = 0;
						}
						$f = 0;
			     }
			 }
			 else if($unit == "month"){
			 	$tickets = Ticket::select(DB::raw('count(*) as ticketCount,month(created_at) as date'))->whereBetween('created_at', [$from, $tomorrow])->groupBy(DB::raw('month(created_at)'))->get();		
			 }
			 	// $year = date("Y",$to);
$d = date_parse_from_format("Y-m-d", $to);
// echo $d["month"];
		 //     $data["points"] = $points;

			// for($i = 0; $i < count($createdTickets); $i++){
			//     $createdTickets[$i] = (int)$createdTickets[$i];
			// } 
		     // $data["createdTickets"] = $createdTickets;
$data["x"] = $d["month"];
			 echo json_encode($tickets);
		}
	}
}
