@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container" id="container">
	<div class="raw">
		<div class="col-md-5"  id="customedate">
			From:<input type="date" id="startdate">
			To:<input type="date" id="enddate">
		</div>
		<div style="float:left;">
			<button class="btn btn-primary" onclick="searchDate()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
		@foreach($allTickets as $allTicket)
	<table class="table ">
		<tr>
			<td>Subject
			<td>Total Ticket Count
			<td>Total Ticket Solved
			<td>Percentages
		</tr>
		  	<tr>
				<td>{{$allTicket->subject->name}}</td>
				<td>{{$allTicket->allticket}}</td>
				<td>{{$allTicket->closedcount}}</td>
				<td>{{$allTicket->percentage}}%</td>
			</tr>
			
	</table>
			<div class="panel panel-default">
			<div class="panel-body" style="background:#FFCCFF;">
			<div class="col-md-3">
				<h4>Tickets Id</h4>
				@foreach($allTicket->ids as $id)
					#{{$id}}<br>
				@endforeach
			</div>
			<div class="col-md-3">
				<h4>Tickets Section/category</h4>
				@foreach($allTicket->sectionCategory as $section)
					{{$section}}<br>
				@endforeach
			</div>
	</div>
			
			</div>
			
		@endforeach

 	
</div>
@endsection
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script type="text/javascript" src="/js/reports/problemmangement.js"></script>
