<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RSB</title>
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
<body class="mybody">
	<nav class="navbar mynav" >
		<div class="container-fluid">
			<div class="navbar-header">
				<button  type="button" class="navbar-toggle collapsed txtnav" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<img class="img-circle" href="{{ url('/home') }}" src="/images/RSB.png" style="height:40px">
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a class="txtnav" href="{{ url('/home') }}">Home</a></li>
					<li><a class="txtnav" href="{{ url('/tickets') }}">Tickets</a></li>
					@if (Auth::check())
						@if(Auth::user()->type == "admin")
							<li><a  class="txtnav" href="{{ url('/assets') }}">Assets</a></li>
							<li><a  class="txtnav" href="{{ url('/users') }}">Users</a></li>
							<li><a class="txtnav" href="{{ url('/sections') }}">Categories&Sections</a></li>							
							<li><a class="txtnav" href="{{ url('/articles') }}">Articles</a></li>
							<li><a class="txtnav" href="{{ url('/reports') }}">Reports</a></li>
						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a class="txtnav" href="{{ url('/auth/login') }}">Login</a></li>
						<li><a class="txtnav" href="{{ url('/auth/register') }}">Register</a></li>
					@else
 
					    <li> <a  class="navbar-brand txtnav" href="/users/{{$current_user->id}}"> {{ ucfirst ($current_user->fname)  }}</a></li>
						<li ><a class="txtnav" href="{{ url('/auth/logout') }}">Logout</a></li>

						@if (Session::get('locale') =="ar")
							<li><a href="/home/setLang?lang=en" class="txtnav" ><span id="locale">E</span></a></li>
						@else
							<li><a href="/home/setLang?lang=ar" class="txtnav" ><span id="locale">ع</span></a></li>
						@endif
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="/bootstrab/js/bootstrap.min.js"></script>

</body>
</html>
