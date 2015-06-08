

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RASESY</title>
	<link href='/bootstrab/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar mynav" >
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/articles/home') }}"><h4>RSB</h4></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/home') }}">Home</a></li>
					<li><a href="{{ url('/tickets') }}">Tickets</a></li>
					@if (Auth::check())
						@if(Auth::user()->type == "admin")
							<li><a href="{{ url('/assets') }}">Assets</a></li>
							<li><a href="{{ url('/users') }}">Users</a></li>
							<li><a href="{{ url('/sections') }}">Categories&Sections</a></li>							
							<li><a href="{{ url('/articles') }}">Articles</a></li>
							<li><a href="{{ url('/reports') }}">Reports</a></li>
						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
					    <li> <a class="navbar-brand" href="/users/{{$current_user->id}}"> {{ ucfirst ($current_user->fname)  }}</a></li>
						<li ><a href="{{ url('/auth/logout') }}">Logout</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
<!-- 	<div class="image">
		
	</div> -->
	@yield('content')

	<!-- Scripts -->
	<script src="/bootstrab/js/bootstrap.min.js"></script>

</body>
</html>
