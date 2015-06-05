@if(Auth::user()->type === "admin")
	@extends('app')
	@section('content')
	<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
	<div class="container-fluid">
	<div class="row">
	 <div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading"> <strong>Choose Date</strong> </div>
			<div class="panel-body">
					<div class="form-group col-md-5">
						<label class="col-md-4 control-label">From</label>
						<input type="text" name="deadline" class="form-control" value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>" id="from" />
					</div>

					<div class="form-group col-md-5">
						<label class="col-md-4 control-label">To</label>
						<input type="text" name="deadline" class="form-control" value="<?php echo date('Y-m-d', strtotime('+0 day')) ?>" id="to"/>
					</div>
					<div class="form-group col-md-2">
					<button type="submit" class="btn btn-primary " onclick="technicianStatisticsSearch ()">Go</button>

					<a  href="{{ url('/assets/csvimport') }}"><img src="/images/CSV.png" style="width:40px"></a>
	
					</div>
			</div>
		</div>
		</div>
		</div>
	</div>

<div class="container-fluid">
	<div class="row">
	 <div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading"> <strong>Technician Statistics</strong> </div>
			<div class="panel-body">

<table class="table table-condensed" id="table_show">
			<tr>
				
				<td class="text-center">Technician</td>
				<td class="text-center">Closed Tickets</td>
				<td class="text-center">Active Tickets</td>
			</tr>

			@for($i = 0; $i < count($technicians); $i++)
				    <tr id="{{ $technicians[$i]['tech_id'] }}">				   		
				   		<td class='subject text-center'><a  href="{{ url('/users/'.$technicians[$i]['tech_id']) }}">{{ $technicians[$i]['fname'] }} {{ $technicians[$i]['lname'] }}</a></td>
				   		<td class="category text-center">
				   			@if($technicians[$i]['closed'] != null)
				   				{{ $technicians[$i]['closed'] }}	
				   			@else
				   				0
				   			@endif
				   		</td>
				   		<td class="status text-center"> 
				   				@if($technicians[$i]['open'] != null)
				   				{{ $technicians[$i]['open'] }} 
				   				@else
				   					0
				   				@endif
				   		</td>

				   </tr>
			  @endfor
		  
		</table>

		</div>
</div>
</div>
</div>
</div>
 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script type="text/javascript" src="/js/reports/technicianStatistics.js"></script>
 

 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>

 <script >
	$(document).ready(function() {

	    $('#from').datetimepicker({
	        format:'Y-m-d H:00:00',
	          });
	    $('#to').datetimepicker({
	        format:'Y-m-d H:00:00',
	          });

 });
 </script>

@endsection
@endif