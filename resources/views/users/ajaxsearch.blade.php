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
							<a href="#" class="transparent" title='Unspam user' onclick="Spam('enable_{{$user->id}}')" ><img src="/images/enable.png" width="30px" height="30px"></a>
							&ensp;&ensp; &ensp;
						@else

							<!-- admin #1 can spam anywone except himself -->
							<!-- regular admins can not spam each other -->
							@if ( ($current_user->id == 1 && $user->id != 1) | $user->type != "admin")
							<a href="#" class="transparent" title='Mark as Spam' onclick="Spam('disable_{{$user->id}}')" ><img src="/images/disable.png" width="30px" height="30px"></a>
							&ensp;&ensp; &ensp;
							@endif
						@endif
						 
						
					@endif

						<!-- admin #1 only can edit his/any admin's profile  -->
						<!-- regular admins can not edit each other profiles-->
						@if ( $current_user->id == "1" | $user->id == $current_user->id | $user->type!="admin") 
							<a href="/users/{{$user->id}}/edit" class="do" title="Edit User"><img src="/images/edit.png" width="30px" height="30px">   </a> 
						@endif

						<!-- admin #1 can not bel deleted  -->
						<!-- admins can not be deleted except by admin #1 -->
						@if ($user->id != "1" && ( $user->type !="admin" || $current_user->id == 1 ))
						 &ensp;&ensp; &ensp;
					 	<a href="#" title="Delete User" onclick="Delete({{$user->id}})"><img src="/images/delete.png" width="30px" height="30px"></a>
					@endif
				</td>

			</tr>
		@endforeach
	</tbody>
</table>
<center><?php echo $users->render(); ?><center>

