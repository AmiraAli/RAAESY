<!DOCTYPE html>
<html>
<head>
<title>RSB</title></head>

<link href='/bootstrab/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/css/login.css">
<body>
<img src="/images/helpdesklogin.jpg" id="bg" alt="" >


<div class="container-fluid mybody">
	<div class="row" >
			<div class="mypanel col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-6">
				<div class="panel-heading panelhead"><b><h4>Reset Password</h4></b></div>
				<div class="panel-body">
				@if (isset ($spamMessage))
					<div class="alert alert-danger">
						{{$spamMessage}}
					</div>		 
				@endif

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<br><br>
						<div class="form-group">
							<label class="col-lg-4 col-sm-4 control-label">E-Mail Address</label>
							<div class="col-lg-6 col-sm-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 col-sm-4 control-label">Password</label>
							<div class="col-lg-6 col-sm-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 col-sm-4 control-label">Confirm Password</label>
							<div class="col-lg-6 col-sm-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-4 col-sm-offset-4">
								<button type="submit" class="btn btn-primary">
									Reset Password
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
	</div>
</div>
</body>
</html>

	<script src="/bootstrab/js/bootstrap.min.js"></script>