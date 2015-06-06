<head>
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>

<body>

@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
	 <div class="col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading"> <center><h3>Reports</h3></center></div>
			<div class="panel-body">
				<div class="col-md-6">
					<div class="row">
						<ul> 
							 <h3><li class="glyphicon glyphicon-list-alt">
						 		<a href="{{ url('/reports/summary') }}">Summary</a><br>
						 		<small style="color: #777;font-size: 11px !important;">Build a ticket-report by date range, category, status and all details</small>
						 	</li></h3>
						 	<br>
						 	<h3><li class="glyphicon glyphicon-signal">
						 		<a href="{{ url('/reports/disthour') }}">Tickets per Hour</a><br>
						 		<small style="color: #777;font-size: 11px !important;">Distription of tickets per hour</small>
						 	</li></h3>
						 	<br>
						 	<h3><li class="glyphicon glyphicon-signal">
						 		<a href="{{ url('/reports/ticketsPerTime') }}">Tickets per Date</a><br>
						 		<small style="color: #777;font-size: 11px !important;">Distription of tickets per day,week.month and custome Date..</small>
						 	</li></h3>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
							<ul> 
								 <h3><li class="glyphicon glyphicon-list-alt">
							 		<a href="{{ url('/reports/logs') }}">Deletion Log</a><br>
							 		<small style="color: #777;font-size: 11px !important;">Contains entries of all destructive
																				 		 actions like deleting and spaning 
																				 		 tickets,categories, assets, users,
																				 		  articles, etc..</small>
							 	</li></h3>
							 	<h3><li class="glyphicon glyphicon-user">
						 		<a href="{{ url('/reports/technicianStatistics') }}">Technician Statistics</a><br>
						 		<small style="color: #777;font-size: 11px !important;">Tickets handled by a user within a date range</small>
						 	</li></h3>
						 	<h3><li class="glyphicon glyphicon-warning-sign">
						 		<a href="{{ url('/reports/problemMangement') }}">problem Mangement</a><br>
						 		<small style="color: #777;font-size: 11px !important;">Analysis no of tickets solved in each subject and which subject has problem </small>
						 	</li></h3>
						 	<h3><li class="glyphicon glyphicon-list-alt">
							 		<a href="{{ url('/reports/reportTicketStatus') }}">Tickets History</a><br>
							 		<small style="color: #777;font-size: 11px !important;">Contains all history of each ticket no of open , no of close
							 																and the date of when opend and when closed..</small>
							 	</li></h3>
							</ul>
					</div>
				</div>
			 </div>
		   </div>
		 </div>
		</div>
	</div>
@endsection
</body>