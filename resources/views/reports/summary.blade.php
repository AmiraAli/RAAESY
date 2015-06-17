@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<link rel="stylesheet" type="text/css" href="/css/reports/summary.css">
<div class="container">
	<h3 class="navtxt"><a href="{{ url('/reports')}}"> Reports</a>
	>>Summary</h3>
</div>
<div class="container" id="container">
<br>
	<div class="row">
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<select class="form-control" id="date" onchange="custom()">
				<option value="month">Last month</option>
		  		<option value="week">Last week</option>
		  		<option value="custom">Custom</option>
			</select>
		</div>
		<div class="col-xs-6 col-sm-5 col-md-6 col-lg-6" style="display:none;" id="customedate">
			<form class="form-inline">
			<div class="form-group">
				<label>From</label>
				<input  class="form-control" type="text" id="startdate">
			</div>
			<div class="form-group">
				<label>To</label>
				<input class="form-control" type="text" id="enddate">
			</div>
			</form>
		</div>
		<div class=" col-xs-4 col-sm-4 col-md-4 col-lg-4" style="float:left;">
			<button class="btn navbtn txtnav hv" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>
			<a  id="csv" href="/reports/summaryCSV">
    	<img src="/images/CSV.png" style="width:40px"></img>
		</a>
		</div>
		
	</div>
	<br>
	<div class="row" id="datainfo">
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-6">
		@if($ticketsPerCategories)
			@foreach($ticketsPerCategories as $ticketsPerCategorie)
				<input type="hidden" class="category" value="{{$ticketsPerCategorie->category->section->name}}/{{$ticketsPerCategorie->category->name}}">
				<input type="hidden" class="count" value="{{ $ticketsPerCategorie->count }}">
			@endforeach
		@endif
    <div  class="divchart" id="piechart" ></div>
		</div>
		<div class=" col-xs-12 col-sm-10 col-md-6">
			<div  class="divchart" id="status" ></div>
		</div>
	</div>
	<br>
	<?php echo $tickets->render(); ?>
	<div class="row divtable table-responsive " >
		<table class=" table table-hover">
			<thead >
				<tr class="navbtn txtnav">
					<th > Ticket ID</th>
					<th> Ticket Subject</th>
					<th> Ticket Category</th>
					<th> Assigned To</th>
					<th> Start Date</th>
					<th> Close Date</th>
					<th> Deadline </th>
					<th> Status </th>
					<th> Priority</th>
				</tr>
			</thead>
			<tbody>
			@foreach($tickets as $ticket)
			<tr>
				<td>#{{ $ticket->id }}</td>
				<td> {{ $ticket->subject->name }} </td>
				<td> {{ $ticket->category->section->name }}/{{ $ticket->category->name }}</td>

				@if($ticket->tech_id != NULL)
					<td> {{ $ticket->tech->fname }}</td>
				@else
					<td></td>
				@endif

				<td> {{ $ticket->created_at }} </td>

				@if($ticket->status == "close")
					<td> {{ $ticket->updated_at }} </td>
				@else
					<td></td>
				@endif

				<td>{{ $ticket->deadline }} </td>
				<td> {{ $ticket->status }} </td>

				@if($ticket->priority == "low")
				   	<td><b class="alert-success ">{{ $ticket->priority }}</b></td>
				@elseif($ticket->priority == "high")
				   	<td><b class="alert-warning">{{ $ticket->priority }}</b></td>
				@else
				   	<td><b class="alert-danger">{{ $ticket->priority }}</b></td>
				@endif
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	</div>
</div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://code.highcharts.com/highcharts.js"></script>
 <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript" src="/js/reports/summarycategory.js"></script>
 <script type="text/javascript" src="/js/reports/summarysearch.js"></script>


 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>


<script type="text/javascript" >
	var Globals = <?php echo json_encode(array(
											    'inprogressCount' => $inprogressCount,
											    'newCount'=>$newCount,
											    'resolvedCount'=>$resolvedCount
											)); ?>;
	$(document).ready(function() {
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
     paginateWithAjax();
 });
google.load("visualization", "1", {packages:["corechart"]});
     google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		['Inprogress',  Globals.inprogressCount],
                ['New',      Globals.newCount],
                ['Resolved',   Globals.resolvedCount] ]);
        var options = {
          title: 'Tickets Status',
	
        };
        var chart = new google.visualization.PieChart(document.getElementById('status'));
        chart.draw(data, options);
      }
//convert pagination to AJAX
function paginateWithAjax(){
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        url = url.replace("/reports/summary/?","/reports/summarySearchDate/?");
        var date=document.getElementById("date").value;
	if( date != "custom"){
		$.ajax({
			      url: url,
			      type: "post",
			      data: {'date':date},
			      success: function(data){
			       $("#container").html(data);
			        paginateWithAjax();
			      },
				  error: function(jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				  }
			    });
	}else{
		var startdate=document.getElementById("startdate").value;
		var enddate=document.getElementById("enddate").value;
		if( startdate != "" && enddate != ""){
			$.ajax({
				      url: url,
				      type: "post",
				      data: {'startdate':startdate, 'enddate':enddate, 'date':date},
				      success: function(data){
				       $("#container").html(data)
				       document.getElementById("customedate").style.display="block";
				        paginateWithAjax();
				      },
					  error: function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					  }
				    });
	}
	}
        
    });
}
</script>
@endsection