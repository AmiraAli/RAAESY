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
						</ul>
					</div>
				</div>
				<div class="col-md-6">
				</div>
			 </div>
		   </div>
		 </div>
		</div>
	</div>
@endsection