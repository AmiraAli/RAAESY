@extends('app')

@section('content')
<div class="container-fluid">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
				 

					@if (isset ($status) )
						<div class="alert alert-success">
							{{ $status }}
						</div>
					@endif
  					@if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
       				@endif
				 

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/users/changepassprocess') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">


						<div class="form-group">
							<label class="col-md-4 control-label">Old Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="oldPassword" >
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">New Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="newPassword">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm New Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="newPassword_confirmation">
							</div>
						</div>


						
			
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Change password
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