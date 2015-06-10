<link href='/bootstrab/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="/css/register.css">

<img src="/images/register8.jpg" id="bg" alt="">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<div class="container-fluid">
	<div class="row" >
			 <div  class="col-lg-5 col-lg-offset-1 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2"> 
				<div class="panel-heading panelhead"><b><h4>Register</h4></b></div>
				<div class="panel-body" id="form-container">
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
								<input type="number" class="form-control" name="phone" value="{{ old('phone') }}">
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
							<div class="col-md-6" id="captcha">
								{!! captcha_img('flat'); !!}
								<br/>
								<a  id="recaptchaLink" onclick="recaptcha();">Re-captcha</a>
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/bootstrab/js/bootstrap.min.js"></script>
 	<script src="/js/auth/register.js"></script>
