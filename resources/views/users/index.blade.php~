<html>
<head>

        <script src="/js/DeleteUser.js"></script>
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')
<div class="container">
<table class="table table-bordered">
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
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

<a href="/users/{{$user->id}}">show</a>
<a href="/users/{{$user->id}}/edit">edit</a>
<a href="#"class="delete" id="{{$user->id}}" onclick="Delete({{$user->id}})">delete</a>
</td>

</tr>
@endforeach
</table>
</div>
@stop
</body>
</html>
