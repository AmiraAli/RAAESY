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
						<input type="date" name="deadline" class="form-control" value="<?php echo date('Y-m-d', strtotime('-31 day')) ?>" id="from" />
					</div>

<div class="form-group col-md-5">
	<label class="col-md-4 control-label">To</label>
	<input type="date" name="deadline" class="form-control" value="<?php echo date('Y-m-d', strtotime('+0 day')) ?>" id="to"/>
</div>
					<div class="form-group col-md-2">
					<button type="submit" class="btn btn-primary " onclick="technicianStatisticsSearch ()">Go</button>
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

			 @foreach($technicians as $technician)
				   <tr id="{{ $technician->tech_id }}">				   		
				   		{{-- <td class="subject text-center"><a  href="{{ url('/users/'.$technician->tech_id) }}"> {{ $technician->user->fname }} {{ $technician->user->lname }}</a></td> --}}
				   		<td class="status text-center"> {{ $technician->open }}</td>
				   		<td class="category text-center">{{ $technician->closed }}</td>
				   		
				   </tr>
			  @endforeach
		  
		</table>

		</div>
</div>
</div>
</div>
</div>
 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
		 <script type="text/javascript" src="/js/reports/technicianStatistics.js"></script>
		 @endsection
@endif