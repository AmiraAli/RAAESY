@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<link rel="stylesheet" type="text/css" href="/css/reports/summary.css">
<div class="container" id="container">
<br>
	<div class="row">
		<div class="col-md-3">
			<select class="form-control" id="date" onchange="custom()">
				<option value="month">Last month</option>
		  		<option value="week">Last week</option>
		  		<option value="custom">Custom</option>
			</select>
		</div>
		<div class="col-md-5" style="display:none;" id="customedate">
			From:<input type="text" id="startdate">
			To:<input type="text" id="enddate">
		</div>
		<div style="float:left;">
			<button class="btn btn-primary" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
		@if($ticketsPerCategories)
			@foreach($ticketsPerCategories as $ticketsPerCategorie)
				<input type="hidden" class="category" value="{{$ticketsPerCategorie->category->section->name}}/{{$ticketsPerCategorie->category->name}}">
				<input type="hidden" class="count" value="{{ $ticketsPerCategorie->count }}">
			@endforeach
		@endif
    <div id="piechart" style="width: 550px; height: 500px;"></div>
		</div>
		<div class="col-md-6">
			<div id="status" style="width: 550px; height: 500px;"></div>
		</div>
	</div>
	<!--csv report-->
 <a id="csv" href="/reports/summaryCSV">

    <img src="/images/CSV.png" style="width:40px"></img>

</a>
	<div class="row">
		<table class="table table-condensed">
			<tr>
			<td > Ticket ID</td>
			<td> Ticket Subject</td>
			<td> Ticket Category</td>
			<td> Assigned To</td>
			<td> Start Date</td>
			<td> Close Date</td>
			<td> Deadline </td>
			<td> Status </td>
			<td> Priority</td>
			</tr>
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
		</table>
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
  		format:'Y-m-d H:00:00',
      	  });
    $('#enddate').datetimepicker({
  		format:'Y-m-d H:00:00',
      	  });

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






</script>
@endsection
