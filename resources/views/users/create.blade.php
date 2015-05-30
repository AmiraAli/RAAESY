@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add User</div>
				<div class="panel-body">
				

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/users/') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">


						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fname" >
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lname">
							</div>
						</div>




						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email"  >
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
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
								<input type="text" class="form-control" name="location" >
							</div>
						</div>


						<div class="form-group">
     						<label class="col-md-4 control-label">Type:</label>
							<div class="col-md-6">
						        <select  name="type">
							        <option value="regular">Regular user</option>
							        <option value="tech">Technician</option>
							        <option value="admin">Admin</option>
							    </select>
						    </div>
					    </div>

						 <div class="form-group">
     						<label class="col-md-4 control-label">Disable:</label>
								<div class="form-group">
		
						            {!! Form::checkbox('isspam', 'value') !!}
		   					    </div>
			
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Add user
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
