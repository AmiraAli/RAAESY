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
