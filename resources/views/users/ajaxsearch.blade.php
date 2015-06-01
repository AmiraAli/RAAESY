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