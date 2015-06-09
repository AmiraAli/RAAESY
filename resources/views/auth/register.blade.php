<link href='/bootstrab/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/css/register.css">

<img src="/images/register8.jpg" id="bg" alt="">

<div class="container-fluid mybody">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class=" mypanel">
				<div class="panel-heading panelhead"><b><h4>Register</h4></b></div>
				<div class="panel-body panel-body">
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label"><b>First Name</b></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fname" value="{{ old('fname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><b>Last Name</b></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lname" value="{{ old('lname') }}">
							</div>
						</div>




						<div class="form-group">
							<label class="col-md-4 control-label"><b>E-Mail Address</b></label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><b>Password</b></label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><b>Confirm Password</b></label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-4 control-label"><b>Phone</b></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-4 control-label"><b>Location</b></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location" value="{{ old('location') }}">
							</div>
						</div>

						<div class="form-group">

							<label class="col-md-4 control-label"><b>Enter the word</b></label>
							<div class="col-md-6">
								{!! captcha_img('flat'); !!}
								<br>
								<input type="text"  class="form-control" name="captcha">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn registerbtn">
									Register
								</button>
								<a href="{{ url('/auth/login') }}"><b>Login</b></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="/bootstrab/js/bootstrap.min.js"></script>
