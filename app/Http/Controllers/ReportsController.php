<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;
use App\TicketStatus;
use App\User;
use Request;
use Auth;
use Response;
use Lang;
use Session;

class ReportsController extends Controller {

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
		
		$logs =Log::paginate(10);
		return view('reports.logs',compact('logs'));
	}


	public function logsAjax()
	{
		
		
		if(!Request::ajax()) {
			return;
		}
		
		$logs =Log::paginate(10);
		return view('reports.logsAjax',compact('logs'));
	}

	public function logsCSV(){
		$logs =Log::all();

		$output="";
		foreach ($logs as $log ) {
			
		
			$output .= implode(",", array('Done By : '.ucfirst ($log->user->fname) , 'at : '.$log->created_at))."\n";
			
			if ( $log->type == 'user'){
	             $name='name';                   
	  	    }elseif ( $log->type == 'article'){
				 $name = 'title'; 
	  	    }else{
				 $name = 'subject'; 
	  	    
		    }


		 	$output .= implode(",", array($log->user->fname));

			if ( $log->action == 'spam'){
				$output .= implode(",", array(" marked the ".$log->type."#".$log->id." with ".$name." ".$log->name." as spam "))."\n";
			}else{
				$output .= implode(",", array($log->action."d the ".$log->type."#".$log->id." with ".$name." ".$log->name))."\n" ;
			}
			
		}
	// headers used to make the file "downloadable", we set them manually
	// since we can't use Laravel's Response::download() function
	$headers = array(
	'Content-Type' => 'text/csv',
	'Content-Disposition' => 'attachment; filename="DelegationLogReport.csv"',
	);

	// our response, this will be equivalent to your download() but
	// without using a local file
	return Response::make(rtrim($output, "\n"), 200, $headers);
		
	}


	/**
	 * Show the distribution/hour of the opened/closed tickets
	 * within the last 10 days
	 *
	 * @return Response
	 */

	public function distHour()
	{
		
		$date1 = date('Y-m-d H:i:s', strtotime('-10day'));
		$date2 = date('Y-m-d H:i:s', time());

		$openedTickets = DB::select("select id ,hour(created_at) as hour ,  count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'open' group by hour(created_at)",array ( $date1 , $date2) );
		$defaultOpen = '';

		
		

		foreach ($openedTickets as $ticket){
			$defaultOpen.=$ticket->hour."_".$ticket->count.":";
		}


		$closedTickets = DB::select("select id ,hour(created_at) as hour  , count(*) as count from  ticket_statuses where created_at between ? and ? and value = 'close' group by hour(created_at)",array ( $date1 , $date2) );
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

		$inprogressCount=Ticket::whereNotNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();
		$newCount=Ticket::whereNull('tech_id')
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

	public function summaryCSV(){


		$tickets=Ticket::where('updated_at','>=',date('Y-m-d', strtotime('-1 month')))->get();
		
		$output = implode(",", array(' Ticket ID', ' Ticket Subject',' Ticket Category',' Assigned To',' Close Date','Deadline','Status',' Priority'))."\n";
		foreach($tickets as $ticket){
			
				if($ticket->tech_id != NULL){
					$fname=$ticket->tech->fname;
				}else{
					$fname= " ";
				}

				if($ticket->status == "close"){
					$updated_at=$ticket->updated_at;
				}else{
					$updated_at=" ";
				}


				
				$output .= implode(",", array($ticket->id , $ticket->subject->name , $ticket->category->section->name , $fname , $updated_at , $ticket->deadline ,$ticket->status ,$ticket->priority)); // append each row
				$output .="\n";
			
		}

        // headers used to make the file "downloadable", we set them manually
		// since we can't use Laravel's Response::download() function
		$headers = array(
		'Content-Type' => 'text/csv',
		'Content-Disposition' => 'attachment; filename="summaryCSV.csv"',
		);

		// our response, this will be equivalent to your download() but
		// without using a local file
		return Response::make(rtrim($output, "\n"), 200, $headers);

	}

	public function summarySearchDate()
	{

		// Getting post data
		if(Request::ajax()) {
			// $data = Input::all();
			$data = Request::input('date');
			if($data == "month"){

				$inprogressCount=Ticket::whereNotNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 month')))
								->count();
				$newCount=Ticket::whereNull('tech_id')
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
				$inprogressCount=Ticket::whereNotNull('tech_id')
								->where('status','open')
								->where('updated_at','>',date('Y-m-d', strtotime('-1 week')))
								->count();
				$newCount=Ticket::whereNull('tech_id')
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

				$inprogressCount=Ticket::whereNotNull('tech_id')
								->where('status','open')
								->where('updated_at','>=',$startdate)
								->where('updated_at','<=',$enddate)
								->count();
				$newCount=Ticket::whereNull('tech_id')
										->where('status','open')
										->where('updated_at','>=',$startdate)
										->where('updated_at','<=',$enddate)
										->count();
				$resolvedCount=Ticket::where('status','close')
										->where('updated_at','>=',$startdate)
										->where('updated_at','<=',$enddate)
										->count();

				$ticketsPerCategories=Ticket::selectRaw('count(*) as count , category_id ')
											->groupBy('category_id')
											->where('updated_at','>=',$startdate)
											->where('updated_at','<=',$enddate)
											->get();

				$tickets=Ticket::where('updated_at','>=',$startdate)
								->where('updated_at','<=',$enddate)
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


	function problemMangementCSV(){

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

        $output = implode(",", array('Subject', 'Total Ticket Count ','Total Ticket Solved ','Percentages'))."\n";
        foreach($allTickets as $allTicket){
        	
			$output .= implode(",", array($allTicket->subject->name ,  $allTicket->allticket , $allTicket->closedcount , $allTicket->percentage )); // append each row
			$output .="\n";
            
            $output .= implode(",", array('Tickets Id', 'Tickets Section/category'))."\n";

            for($i=0;$i<sizeof($allTicket->ids); $i++){
					$id=$allTicket->ids[$i];
					$section=$allTicket->sectionCategory[$i];
					$output .= implode(",", array($id,$section))."\n";
			}

		}
			
				// headers used to make the file "downloadable", we set them manually
			// since we can't use Laravel's Response::download() function
			$headers = array(
			'Content-Type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename="ProblemManagmentReport.csv"',
			);

			// our response, this will be equivalent to your download() but
			// without using a local file
			return Response::make(rtrim($output, "\n"), 200, $headers);

       



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
	if($allTickets){
		return view('reports.ticketStatisticsDate',compact('allTickets','startdate','enddate'));
	}else{
		echo "<h1 class='navtxt'> No Tickets Within this range of date!</h1>";
	}
}


	public function technicianStatistics()
	{

		$from = date('Y-m-d', strtotime('-1 month'));
		$to = date('Y-m-d', strtotime('+1 day'));

		// $technicians = DB::select("select count(IF(tickets.status = 'close', 1, null)) as closed, count(IF(tickets.status = 'open', 1, null)) as open, users.fname, users.lname, users.id from users left join tickets on users.id = tickets.tech_id where users.type = 'tech' group by tickets.tech_id");
		$technicians_close = DB::select("select users.fname, users.lname, state.tech_id, state.closed from users left join(select count(IF(t2.value = 'close', 1, null)) as closed, tickets.tech_id from tickets left join (SELECT ts.ticket_id,created_at,value  FROM ticket_statuses ts  join (SELECT ticket_id,Max(created_at) as ma FROM ticket_statuses where created_at between '$from' and '$to' GROUP BY ticket_id ) t on t.ma=ts.created_at and t.ticket_id=ts.ticket_id) t2 on t2.ticket_id = tickets.id group by(tickets.tech_id)) state on users.id = state.tech_id where users.type='tech'");
		$technicians_open = DB::select("select users.fname, users.lname, state.tech_id, state.open from users left join(select count(IF(t2.value = 'open', 1, null)) as open, tickets.tech_id from tickets left join (SELECT ts.ticket_id,created_at,value  FROM ticket_statuses ts  join (SELECT ticket_id,Max(created_at) as ma FROM ticket_statuses where created_at <= '$to' GROUP BY ticket_id ) t on t.ma=ts.created_at and t.ticket_id=ts.ticket_id) t2 on t2.ticket_id = tickets.id group by(tickets.tech_id)) state on users.id = state.tech_id where users.type='tech'");
		
		$technicians = array();
	    $i = 0;			    	
        foreach ($technicians_close as $tech_close){	        
            $technicians[$i]["closed"] = $tech_close->closed;
            $technicians[$i]["tech_id"] = $tech_close->tech_id;
            $technicians[$i]["fname"] = $tech_close->fname;
            $technicians[$i]["lname"] = $tech_close->lname;
            $i++;
        }
        $i = 0;	
        foreach ($technicians_open as $tech_open){	        
            $technicians[$i]["open"] = $tech_open->open;
            $i++;
        }

		return view('reports.technicianStatistics',compact("technicians"));

	}
	public function technicianStatisticsSearch()
	{
		

			$from = Request::get('from');
			$to = Request::get('to');
			$tomorrow = date('Y-m-d',strtotime($to . "+1 days"));

			$technicians_close = DB::select("select users.fname, users.lname, state.tech_id, state.closed from users left join(select count(IF(t2.value = 'close', 1, null)) as closed, tickets.tech_id from tickets left join (SELECT ts.ticket_id,created_at,value  FROM ticket_statuses ts  join (SELECT ticket_id,Max(created_at) as ma FROM ticket_statuses where created_at between '$from' and '$tomorrow' GROUP BY ticket_id ) t on t.ma=ts.created_at and t.ticket_id=ts.ticket_id) t2 on t2.ticket_id = tickets.id group by(tickets.tech_id)) state on users.id = state.tech_id where users.type='tech'");
			$technicians_open = DB::select("select users.fname, users.lname, state.tech_id, state.open from users left join(select count(IF(t2.value = 'open', 1, null)) as open, tickets.tech_id from tickets left join (SELECT ts.ticket_id,created_at,value  FROM ticket_statuses ts  join (SELECT ticket_id,Max(created_at) as ma FROM ticket_statuses where created_at <= '$tomorrow' GROUP BY ticket_id ) t on t.ma=ts.created_at and t.ticket_id=ts.ticket_id) t2 on t2.ticket_id = tickets.id group by(tickets.tech_id)) state on users.id = state.tech_id where users.type='tech'");
			
			$technicians = array();
		    $i = 0;			    	
	        foreach ($technicians_close as $tech_close){	        
	            $technicians[$i]["closed"] = $tech_close->closed;
	            $technicians[$i]["tech_id"] = $tech_close->tech_id;
	            $technicians[$i]["fname"] = $tech_close->fname;
	            $technicians[$i]["lname"] = $tech_close->lname;
	            $i++;
	        }
	        $i = 0;	
	        foreach ($technicians_open as $tech_open){	        
	            $technicians[$i]["open"] = $tech_open->open;
	            $i++;
	        }
	        return view('reports.technicianSearch',compact("technicians"));
	}

	public function ticketsPerTime()
	{
		$from = date('Y-m-d', strtotime('-2 day'));
		$to = date('Y-m-d', strtotime('+1 day'));
		$tomorrow = date('Y-m-d',strtotime($to . "+1 days"));
		$tickets = Ticket::select(DB::raw('count(*) as ticketCount,DATE(created_at) as date'))->whereBetween('created_at', [$from, $to])->groupBy(DB::raw('DATE(created_at)'))->get();	
		$closed = DB::select("select count(IF(ts.value = 'close', 1, null)) as closed,date(ts.created_at) as date from ticket_statuses ts  join (select created_at,ticket_id FROM (select * from ticket_statuses order by created_at desc) td  where created_at between '$from' and '$tomorrow' group by ticket_id,date(created_at) ) x on x.created_at=ts.created_at and x.ticket_id=ts.ticket_id and value='close' group by date(ts.created_at)");
		
		$points[0] = date('Y-m-d', strtotime('-2 day'));
		$points[1] = date('Y-m-d', strtotime('-1 day'));
		$points[2] = date('Y-m-d', strtotime('+0 day'));
		$f = 0;
		$fClosed=0;
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
		foreach ($points as $point) {
			foreach ($closed as $closedTicket) {					
				if(strtotime($closedTicket->date) == strtotime($point)){
					$closedTickets[] = $closedTicket->closed;
					$fClosed = 1;

				}
			}
			if($fClosed == 0){
				$closedTickets[] = 0;

			}
			$fClosed = 0;
		}			
		return view('reports.ticketsPerTime', compact('points','createdTickets','closedTickets'));
	}


	public function prepareTickets()
	{
		if( Request::ajax() ) {
			$unit = Request::input("unit");
			$from = Request::input("from");
			$to = Request::input("to");
			$tomorrow = date('Y-m-d',strtotime($to . "+1 days"));
			$dateFrom = date_parse_from_format("Y-m-d", $from);
			$dateTo = date_parse_from_format("Y-m-d", $to);

			if($unit == "day"){
				
				$tickets = Ticket::select(DB::raw('count(*) as ticketCount,DATE(created_at) as date'))->whereBetween('created_at', [$from, $tomorrow])->groupBy(DB::raw('DATE(created_at)'))->get();	
				$closed = DB::select("select count(IF(ts.value = 'close', 1, null)) as closed,date(ts.created_at) as date from ticket_statuses ts  join (select created_at,ticket_id FROM (select * from ticket_statuses order by created_at desc) td  where created_at between '$from' and '$tomorrow' group by ticket_id,date(created_at) ) x on x.created_at=ts.created_at and x.ticket_id=ts.ticket_id and value='close' group by date(ts.created_at)");

			     $datediff = strtotime($to) - strtotime($from);
			     $timeDiff = floor($datediff/(60*60*24));
			     $f = 0;
			     for($i = 0; $i <= $timeDiff; $i++){
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

			     $fDay = 0;
			     for($i = 0; $i <= $timeDiff; $i++){
			     	$points[$i] = date('Y-m-d',strtotime($from . "+".$i ."days"));
				     	foreach ($closed as $ticketClosed) {			
							if(strtotime($ticketClosed->date) == strtotime($points[$i])){
								$closedTickets[] = $ticketClosed->closed;
								$fDay = 1;
							}
						}
						if($fDay == 0){
							$closedTickets[] = 0;
						}
						$fDay = 0;
			     }
			 }
			 else if($unit == "month"){
			 	$tickets = Ticket::select(DB::raw('count(*) as ticketCount,month(created_at) as date'))->whereBetween('created_at', [$from, $tomorrow])->groupBy(DB::raw('month(created_at)'))->get();		
			 	$closed = DB::select("select count(IF(ts.value = 'close', 1, null)) as closed,month(ts.created_at) as date from ticket_statuses ts  join (select created_at,ticket_id FROM (select * from ticket_statuses order by created_at desc) td  where created_at between '$from' and '$tomorrow' group by ticket_id,month(created_at) ) x on x.created_at=ts.created_at and x.ticket_id=ts.ticket_id and value='close' group by month(ts.created_at)");

			 	$f = 0;
			 	for($i = 0; $i <= ($dateTo["month"] - $dateFrom["month"]); $i++){
			     	$points[$i] = $dateFrom["month"] + $i;
				     	foreach ($tickets as $ticket) {			
							if($ticket->date == $points[$i]){
								$createdTickets[] = $ticket->ticketCount;
								$f = 1;
							}
						}
						if($f == 0){
							$createdTickets[] = 0;
						}
						$f = 0;
			     }

			    $fMonth = 0;
			 	for($i = 0; $i <= ($dateTo["month"] - $dateFrom["month"]); $i++){
			     	$points[$i] = $dateFrom["month"] + $i;
				     	foreach ($closed as $ticketClosed) {			
							if($ticketClosed->date == $points[$i]){
								$closedTickets[] = $ticketClosed->closed;
								$fMonth = 1;
							}
						}
						if($fMonth == 0){
							$closedTickets[] = 0;
						}
						$fMonth = 0;
			     }

			 }
			 else if($unit == "week"){
			 	$tickets = Ticket::select(DB::raw('count(*) as ticketCount,week(created_at) as date'))->whereBetween('created_at', [$from, $tomorrow])->groupBy(DB::raw('week(created_at)'))->get();		
			 	$closed = DB::select("select count(IF(ts.value = 'close', 1, null)) as closed,week(ts.created_at) as date from ticket_statuses ts  join (select created_at,ticket_id FROM (select * from ticket_statuses order by created_at desc) td  where created_at between '$from' and '$tomorrow' group by ticket_id,week(created_at) ) x on x.created_at=ts.created_at and x.ticket_id=ts.ticket_id and value='close' group by week(ts.created_at)");

			 	$fromDate  = mktime(0, 0, 0, $dateFrom["month"],$dateFrom["day"],$dateFrom["year"]);
				$weekFrom  = (int)date('W', $fromDate);
				$toDate  = mktime(0, 0, 0, $dateTo["month"],$dateTo["day"],$dateTo["year"]);
				$weekTo  = (int)date('W', $toDate);
			 	$f = 0;
			 	for($i = 0; $i <= ($weekTo - $weekFrom); $i++){
			     	$points[$i] = $weekFrom + $i;
				     	foreach ($tickets as $ticket) {			
							if($ticket->date == $points[$i] - 1){
								$createdTickets[] = $ticket->ticketCount;
								$f = 1;
							}
						}
						if($f == 0){
							$createdTickets[] = 0;
						}
						$f = 0;
			     }

			     $fWeek = 0;
			 	for($i = 0; $i <= ($weekTo - $weekFrom); $i++){
			     	$points[$i] = $weekFrom + $i;
				     	foreach ($closed as $ticketClosed) {			
							if($ticketClosed->date == $points[$i] - 1){
								$closedTickets[] = $ticketClosed->closed;
								$fWeek = 1;
							}
						}
						if($fWeek == 0){
							$closedTickets[] = 0;
						}
						$fWeek = 0;
			     }

			 }
		     $data["points"] = $points;

			for($i = 0; $i < count($createdTickets); $i++){
			    $createdTickets[$i] = (int)$createdTickets[$i];
			} 
			for($i = 0; $i < count($closedTickets); $i++){
			    $closedTickets[$i] = (int)$closedTickets[$i];
			}
		     $data["createdTickets"] = $createdTickets;
		     $data["closedTickets"] = $closedTickets;
			 echo json_encode($data);
		}
	}


	public function reportTicketStatus(){

		$tickets=Ticket::paginate(2);
		$ticketStatuses= TicketStatus::all();
		$opens=TicketStatus::where('value','open')->count();
		$closes=TicketStatus::where('value','close')->count();
		return view('reports.reportTicketStatus',compact('tickets','ticketStatuses','opens','closes'));
	}


	/**
	 * Show the ticket Status of the opened/closed tickets ( called by AJAX )
	 *
	 * @return Response
	 */

	public function reportTicketStatusAjax(){

		$tickets=Ticket::paginate(2);
		$ticketStatuses= TicketStatus::all();
		$opens=TicketStatus::where('value','open')->count();
		$closes=TicketStatus::where('value','close')->count();
		return view('reports.reportTicketStatusAjax',compact('tickets','ticketStatuses','opens','closes'));
	}

	public function exportTicketStatusReport(){

		$tickets=Ticket::all();
		$ticketStatuses= TicketStatus::all();

	    $open= array(); $close= array(); 
	    foreach($tickets as $ticket){
			$countOpen=0; $countClose=0; 
		    foreach($ticketStatuses as $ticketStatus){
				  			
				if($ticketStatus->ticket_id==$ticket->id){
					if($ticketStatus->value=='open'){
						
							$countOpen=$countOpen+1;
							$open[$ticket->id]=$countOpen; 
					
					
					}
					if($ticketStatus->value=='close'){
						
							$countClose=$countClose+1;
							$close[$ticket->id]=$countClose; 
						 
					}
				
				}
			}
		}		
			



        $output = implode(",", array('id', 'subject','Current Status','No of Open','No of Close'))."\n";

		foreach ($tickets as $row) {
		// iterate over each tweet and add it to the csv
			if(!empty($open[$row->id])){
							$noOpen = $open[$row->id] ;
			}else{
							$noOpen = 0;
						
			}			
			if(!empty( $close[$ticket->id] )){
							$noClose = $close[$row->id];
			}else{
							$noClose = 0;
			}			
		    $output .= implode(",", array($row['id'], $row->subject->name ,$row['status'],$noOpen,$noClose)); // append each row
			$output .="\n";

		    foreach($ticketStatuses as $ticketStatus){

						if($ticketStatus->ticket_id==$row->id){
							$value=$ticketStatus->value ;
							$created_at=$ticketStatus->created_at ;
							$output .= implode(",", array($value,$created_at)); // append each row
							$output .="\n";
							
						}


			}
			
		}

		// headers used to make the file "downloadable", we set them manually
		// since we can't use Laravel's Response::download() function
		$headers = array(
		'Content-Type' => 'text/csv',
		'Content-Disposition' => 'attachment; filename="TicketStatusReport.csv"',
		);

		// our response, this will be equivalent to your download() but
		// without using a local file
		return Response::make(rtrim($output, "\n"), 200, $headers);
	

	}





public function problemMangementLang(){

    $lang=Request::input("lang");
	if($lang=="ع"){
    	Session::set('locale', 'ar');
    	Lang::setLocale('ar');
    }
	if($lang=="E"){
      	Session::set('locale', 'en');
      	Lang::setLocale('en');

	}


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
	return  view('reports.problemMangementLang',compact('lang','allTickets','startdate','enddate'));
	

	}






}
