<table class="table table-hover ">
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
@if ($showType)
<th>Role</th>
@endif
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
@if ($showType)
<td>
   @if ($user->type == "admin")
    	Admin
    @elseif ($user->type == "tech")
    	Technician
    @else
    	Regular User
    @endif
</td>
@endif





<td class="text-center">

@if ($user->id != "1" | ($user->id == "1" && $current_user->id == "1" ) )
	<a class="transparent" href="/users/{{$user->id}}/edit"><img src="/images/edit.png"></a>
@endif

@if ($user->id != "1")
	@if ($showType)
		<button class="transparent" onclick="Spam('enable_{{$user->id}}')" ><img src="/images/enable.png"></button>
	@else
		<button class="transparent" onclick="Spam('disable_{{$user->id}}')" ><img src="/images/disable.png"></button>
	@endif

	<button class="transparent" onclick="Delete({{$user->id}})" ><img src="/images/delete.png"></button>
@endif
</td>

</tr>
@endforeach
</tbody>
</table>
