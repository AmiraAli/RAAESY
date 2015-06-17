
<br>
	<div class="row">
		<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
			<select class="form-control" id="date" onchange="custom()">
				<option value="month">Last month</option>
		  		<option value="week" selected="true">Last week</option>
		  		<option value="custom">Custom</option>
			</select>
		</div>
		<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="display:none;" id="customedate">
			<label class="col-xs-3 col-md-2">From</label><input  class="col-xs-3 col-md-4" type="text" id="startdate">
			<label class="col-xs-2 col-md-2">To</label><input class="col-xs-3 col-md-4" type="text" id="enddate">
		</div>
		<div class=" col-xs-4 col-sm-4 col-md-4 col-lg-4" style="float:left;">
			<button class="btn navbtn txtnav" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>
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
	<div class="row divtable table-responsive" >
		<table class="table table-hover">
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

 });


google.load("visualization", "1", {packages:["corechart"]});

drawChart();
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

