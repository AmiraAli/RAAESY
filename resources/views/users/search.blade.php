@if (Auth::check())
<html>
<head>  
     
     <script src="/js/users/index.js"></script>
       
</head>

<body>


<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

@extends('app')
@section('content')


<div class="container col-md-8"  style="border:solid 2px;" id="con"> 
</div>

	<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">Search</div>
				<div class="panel-body">

						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-6">
								<input type="text" id="fname" class="form-control" name="fname" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="text" id="lname" class="form-control" name="lname" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Phone</label>
							<div class="col-md-6">
								<input type="text" id="phone" class="form-control" name="phone">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" id="location" class="form-control" name="location">
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
</body>
</html>
@endif