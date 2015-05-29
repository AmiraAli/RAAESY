<html>
<head>

     
	 <script src="/js/DeleteUser.js"></script>
 	 <script src="/js/users/index.js"></script>
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
<input type="text" class="glyphicon glyphicon-search parent" onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">




<div id="autocompletemenu" style="display: none;">
   <ul id="autocompleteul"></ul>
</div>
</div>


<div class="container">
<table class="table table-bordered">
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
<th>Disabled</th>
<tbody id="tbody">
@foreach($users as $user)
<tr id="{{$user->id}}"><td>
{{$user->fname}}	
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



<td>

<a class="btn btn-primary" href="/users/{{$user->id}}">show</a>
<a class="btn btn-primary" href="/users/{{$user->id}}/edit">edit</a>
<a class="btn btn-primary delete" href="#"  id="{{$user->id}}" onclick="Delete({{$user->id}})">delete</a>
</td>

</tr>
@endforeach
</tbody>
</table>
<a class="btn btn-primary" href="/users/create" >Create new user</a>



</div>

@stop

</body>
</html>
