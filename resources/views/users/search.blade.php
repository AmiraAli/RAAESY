@extends('app')
@section('content')


<div class="container col-md-8"  style="border:solid 2px;" > <!--style="float:left; border:solid 2px; width:50%" >-->
</div>

	<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">Search</div>
				<div class="panel-body">
	

<!-- 					<form class="form-horizontal" role="form" method="POST" action="{{ url('/users/ajaxsearch') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
 -->

						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-6">
								<input type="fname" class="form-control" name="fname" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="lname" class="form-control" name="lname" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Phone</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" onclick="search()" class="btn btn-primary">Search</button>
							</div>
						</div>


		

		</div></div></div>				
</div>
@stop
