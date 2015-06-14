<table class="table table-hover">
	<thead>
		<tr class="navbtn txtnav">
			<th class="text-center">Name</th>
			<th class="text-center">Email</th>
			<th class="text-center">Phone</th>
			<th class="text-center">Location</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody id="tbody">
		@foreach($users as $user)
			<tr id="{{$user->id}}">
				<td class="text-center"><a href="/users/{{$user->id}}"><b>{{$user->fname}}	{{$user->lname}}</b></a></td>
				<td class="text-center">{{$user->email}}</td>
				<td class="text-center">{{$user->phone}}</td>
				<td class="text-center">{{$user->location}}</td>        
				<td class="text-center">
					@if ($user->id != "1") 

						@if ($showType)
							<a href="#" class="transparent enable" onclick="Spam('enable_{{$user->id}}')" ><img src="/images/enable.png" width="30px" height="30px"></a>
							&ensp;&ensp; &ensp;
						@else
							<a href="#" class="transparent disable" onclick="Spam('disable_{{$user->id}}')" ><img src="/images/disable.png" width="30px" height="30px"></a>
							&ensp;&ensp; &ensp;
						@endif
						 
						
					@endif
					@if ($user->id != "1" | ($user->id == "1" && $current_user->id == "1" ) )
						<a href="/users/{{$user->id}}/edit" class="do"><img src="/images/edit.png" width="30px" height="30px">   </a> 
					@endif

					@if ($user->id != "1")
						 &ensp;&ensp; &ensp;
					 	<a href="#" id="{{$user->id}}" onclick="Delete({{$user->id}})"><img src="/images/delete.png" width="30px" height="30px"></a>
					@endif
				</td>

			</tr>
		@endforeach
	</tbody>
</table>