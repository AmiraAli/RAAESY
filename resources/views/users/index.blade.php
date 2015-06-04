<html>
<head>

     
	<script src="/js/DeleteUser.js"></script>
 	<script src="/js/users/index.js"></script>
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="/js/users/toggleSearch.js"></script>
 	<link rel="stylesheet" type="text/css" href="/css/users/index.css">

        
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')


<div class="container">

Show: 
<label><input type="radio" name="user" value="all"   onclick="show(this)"> All</label> |
<label><input type="radio" name="user" value="regular"   onclick="show(this)">  Regular Users</label> | 
<label><input type="radio" name="user" value="tech"  onclick="show(this)">  Technicians</label> |
<label><input type="radio" name="user" value="admin"  onclick="show(this)">  Admins </label>|
<label><input type="radio" name="user" value="disabled"  onclick="show(this)">  Disabled users </label>|

<label for="">Quick Search: </label>
<input type="text" class="parent" placeholder="Fname/Lname/Email" onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">
<a class="btn btn-primary" href="/users/create" >Create New User</a>
<button id="toggle" class="btn btn-primary" > <span class="glyphicon glyphicon-search"></span></button>

<a id="csv" href="users/downloadCSV" ><img src="/images/CSV.png"></a>
<a id="pdf" href="users/downloadPDF" ><img src="/images/CSV.png"></a>

<div id="autocompletemenu" style="display: none;">
   <ul id="autocompleteul"></ul>
</div>
</div>

</br>
<div  id="con" class="col-md-12" >
<table class="table table-hover ">
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
<th>Disabled</th>
<tbody id="tbody">
@foreach($users as $user)
<tr id="{{$user->id}}"><td>
<a href="/users/{{$user->id}}">{{$user->fname}}	</a>
</td>
<td>
	{{$user->lname}}	

</td>
<td>
	{{$user->email}}	

</td>

<td>
	{{$user->phone}}	

</td>
<td>
	{{$user->location}}	

</td>
<td>
	@if ($user->isspam == true)

		<input type="checkbox" disabled="true" checked="true">
	@else
		<input type="checkbox" disabled="true" >
	@endif

</td>



<td class="text-center">


<a class="btn btn-success" href="/users/{{$user->id}}/edit">edit</a>
<a class="btn btn-danger delete" href="#"  id="{{$user->id}}" onclick="Delete({{$user->id}})">delete</a>
</td>

</tr>
@endforeach
</tbody>
</table>



</div>


<div class="col-md-4" id="advancedSearchDiv">
		<div class="panel panel-success">
			<div class="panel-heading">Search</div>
				<div class="panel-body">
                  
						<div class="form-group">
							<label class="col-md-6 control-label">First Name</label>
							<div class="col-md-6">
								<input type="text" id="fname" class="form-control" name="fname" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-6 control-label">Last Name</label>
							<br/>
							<div class="col-md-6">
								<input type="text" id="lname" class="form-control" name="lname" value="{{ old('email') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-6 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-6 control-label">Phone</label>
							<div class="col-md-6">
								<input type="text" id="phone" class="form-control" name="phone">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-6 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" id="location" class="form-control" name="location">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" onclick="search()" class="btn btn-primary">Search</button>
							</div>
						</div>


		

		</div>
			</div>
				</div>				
</div>



@stop

</body>
</html>
