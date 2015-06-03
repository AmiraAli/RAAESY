<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Log;
use App\Ticket;
use DB;
use Illuminate\Http\Request;

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
	 * Show the form for creating a new resource.
	 *
	 * 
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
	public function problemMangementDate(Request $request){
	
	$startdate=$request->input('startdate');
	$enddate=$request->input('enddate');

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





}
