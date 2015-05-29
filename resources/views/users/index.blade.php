<html>
<head>

        <script src="/js/DeleteUser.js"></script>
        <script src="/js/users/index.js"></script>
        <style>
        	label{
        		margin : 10px;
        	}


        </style>
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')

Show: 
<label><input type="radio" name="user" value="all"   onclick="show(this)"> All</label> |
<label><input type="radio" name="user" value="regular"   onclick="show(this)">  Regular Users</label> | 
<label><input type="radio" name="user" value="tech"  onclick="show(this)">  Technicians</label> |
<label><input type="radio" name="user" value="admin"  onclick="show(this)">  Admins </label>|
<label><input type="radio" name="user" value="disabled"  onclick="show(this)">  Disabled users </label>|






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

<a href="/users/{{$user->id}}">show</a>
<a href="/users/{{$user->id}}/edit">edit</a>
<a href="#"class="delete" id="{{$user->id}}" onclick="Delete({{$user->id}})">delete</a>
</td>

</tr>
@endforeach
</tbody>
</table>
</div>
@stop


</body>
</html>
