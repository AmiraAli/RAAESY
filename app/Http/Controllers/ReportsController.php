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
use App\TicketStatus;

class ReportsController extends Controller {
	/**
	* Function to sort tickets
	**/
	public function sortTicket( $tickt , $sortBy ,$sortType )
	{
		if(is_object($tickt) && ! $tickt->isEmpty() )
		{		
    		$tickets = array();
	    			    	
	        foreach ($tickt as $key => $value)
	        {	        
	            $tickets[$key] = $value;
            
	        }
	        foreach ($tickets as $key => $row)
			{
				if ($sortBy == "subject") 
				{		
					$sort[$key] = $row['subject']['name'];
				}
				else 
				{
					$sort[$key] = $row[$sortBy];
				}			    				    
			}


			//sorting function
			if ($sortType == "DESC") 
			{	
				if($sortBy == "percentage")
				{
					array_multisort($sort, SORT_DESC, $tickets);
				}
				else
				{	
					array_multisort($sort, SORT_ASC, $tickets);
				}
			}
			elseif ($sortType == "ASC")
			{
				if($sortBy == "percentage")
				{
					array_multisort($sort, SORT_ASC, $tickets);
				}
				else
				{	
					array_multisort($sort, SORT_DESC, $tickets);
				}
			}
			return $tickets; 
		}	
	   
	    
		return $tickt;		
	}


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
	 * 
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


	/**
	 * function to get  the problem mangement.
	 *
	 * @return Response
	 */
	public function problemMangement()
	{

	$allTickets=Ticket::selectRaw('count(*) as allticket ,subject_id ')->groupBy('subject_id')->get();
	$all=Ticket::all();

	foreach($allTickets as $allTicket){
	$count=0;
	$idsPerSubject=array();
	$sectionCategoryPerSubject=array();
		foreach($all as $ticket){
			if($ticket->subject->name==$allTicket->subject->name  ){
				if($ticket->status=='close'){
					$count=$count+1;
				}
				$idsPerSubject[]=$ticket->id;
				$sectionCategoryPerSubject[]=$ticket->category->section->name.'/'.$ticket->category->name;
				}
		}
		$percentage=($count/$allTicket->allticket)*100;
		$allTicket->closedcount=$count;
		$allTicket->percentage=$percentage;
		$allTicket->ids=$idsPerSubject;
		$allTicket->sectionCategory=$sectionCategoryPerSubject;
	}
	$allTickets=$this->sortTicket( $allTickets , 'percentage' ,'ASC' );
	return view('reports.ticketStatistics',compact('allTickets'));
	}


	/**
	 * function to get  the problem mangement by date.
	 *
	 * @return Response
	 */
	public function problemMangementDate(){
	
	$startdate=Request::input('startdate');
	$enddate=Request::input('enddate');

	$allTickets=Ticket::selectRaw('count(*) as allticket ,subject_id ')->whereBetween('updated_at', [$startdate, $enddate])
									   ->groupBy('subject_id')->get();
	$all=Ticket::all();

	foreach($allTickets as $allTicket){
	$count=0;
	$idsPerSubject=array();
	$sectionCategoryPerSubject=array();
		foreach($all as $ticket){
			if($ticket->subject->name==$allTicket->subject->name  ){
				if($ticket->status=='close'){
					$count=$count+1;
				}
				$idsPerSubject[]=$ticket->id;
				$sectionCategoryPerSubject[]=$ticket->category->section->name.'/'.$ticket->category->name;
				}
		}
		$percentage=($count/$allTicket->allticket)*100;
		$allTicket->closedcount=$count;
		$allTicket->percentage=$percentage;
		$allTicket->ids=$idsPerSubject;
		$allTicket->sectionCategory=$sectionCategoryPerSubject;
	}

	$allTickets=$this->sortTicket( $allTickets , 'percentage' ,'ASC' );
	return view('reports.ticketStatisticsDate',compact('allTickets','startdate','enddate'));
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
<<<<<<< HEAD
			$technicians = DB::select("select count(IF(tickets.status = 'close', 1, null)) as closed, count(IF(tickets.status = 'open', 1, null)) as open, users.fname, users.lname, users.id from users left join tickets on users.id = tickets.tech_id where users.type = 'tech' group by tickets.tech_id");
		
=======


>>>>>>> da7412630bc25503e00fd7b9046c670da6e0f70f
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

<<<<<<< HEAD
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
=======

	public function reportTicketStatus(){

		$tickets=Ticket::all();
		$ticketStatuses= TicketStatus::all();
		$opens=TicketStatus::where('value','open')->count();
		$closes=TicketStatus::where('value','close')->count();
		return view('reports.reportTicketStatus',compact('tickets','ticketStatuses','opens','closes'));
	}



>>>>>>> da7412630bc25503e00fd7b9046c670da6e0f70f
}
