@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">
    <h3 class="navtxt"><a href="{{ url('/reports')}}"> Reports</a>
    >>Problem Mangement</h3>
</div>
<div class="container" id="container">
<br>
	<div class="raw">
		<div class="col-md-5"  id="customedate">
			{{trans('problemmangement.from')}}:<input type="text" id="startdate">
			{{trans('problemmangement.to')}}:<input type="text" id="enddate">
		</div>
		<div style="float:left;">
			<button class="btn navbtn txtnav" onclick="searchDate()"><span class="glyphicon glyphicon-search" style=" color: #ffffff !important;"></span></button>
		</div>
		 <!--csv report-->
		 <a  id="csv" href="/reports/problemMangementCSV">
		    <img src="/images/CSV.png" style="width:40px"></img>
		</a>
	</div>
	
	<br><br>
	<?php
	if (empty(json_decode(json_encode($allTickets), true)))
	{
		echo "<h2 class='navtxt'> No Tickets within this range of date!!</h2>";
	}else{
	?>
		@foreach($allTickets as $allTicket)
	<table class="table table-hover" >
		<thead>
		<tr class="navbtn txtnav">
			<th>{{trans('problemmangement.subject')}}</th>
			<th>{{trans('problemmangement.total ticket count')}}</th>
			<th>{{trans('problemmangement.total ticket solved')}}</th>
			<th>{{trans('problemmangement.percentages')}}</th>
		</tr>
		</td>
		<tbody>
		@if ($allTicket->percentage < 25)
		  	<tr style="background:rgba(240,96,86,0.85); color:#FFF;">
		@else
			<tr>
		@endif
				<td>{{$allTicket->subject->name}}</td>
				<td>{{$allTicket->allticket}}</td>
				<td>{{$allTicket->closedcount}}</td>
				<td>{{$allTicket->percentage}}%</td>
			</tr>
		
		</tbody>
	</table>
			<div class="panel panel-default">
			<div class="panel-body" style="background:#bce0ee;">
			<div class="col-md-3">
				<h4>{{trans('problemmangement.ticketsid')}}</h4>
				@foreach($allTicket->ids as $id)
					#{{$id}}<br>
				@endforeach
			</div>
			<div class="col-md-3">
				<h4>{{trans('problemmangement.tickets sections/category')}}</h4>
				@foreach($allTicket->sectionCategory as $section)
					{{$section}}<br>
				@endforeach
			</div>
	</div>
			
			</div>
			
		@endforeach
	<?php
}
?>
</div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script type="text/javascript" src="/js/reports/problemmangement.js"></script>




 <!-- DateTime picker -->
 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>
<script >
 window.onload = function() {
    $.ajaxSetup({
	    headers: {
	        'X-XSRF-Token': $('meta[name="_token"]').attr('content')
	             }
	});

	    $('#startdate').datetimepicker({
	  		format:'Y-m-d',
            timepicker:false,
            mask:true,
	    });
	    $('#enddate').datetimepicker({
	  		format:'Y-m-d',
            timepicker:false,
            mask:true,
	    });
};
</script>
@endsection

