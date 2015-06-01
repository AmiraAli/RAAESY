	<table class="table table-condensed">
			<tr>
				
				<td class="text-center">Subject</td>
				<td class="text-center">Status</td>
				<td class="category text-center">Category</td>
				<td class="text-center">Creation date</td>
				<td class="text-center">Dead line</td>
				<td class="priority text-center">Periorty</td>
				<td class="text-center">Settings</td>
			</tr>
			  @foreach($tickets as $ticket)
				   <tr id="{{ $ticket->id }}">
				   		
				   		<td class="text-center">{{ $ticket->subject->name }}</td>
				   		<td class="text-center"> {{ $ticket->status }}</td>
				   		<td class="category text-center">{{ $ticket->category->name }}</td>
				   		<td class="text-center">{{ $ticket->created_at }} </td>
				   		<td class="text-center">{{ $ticket->deadline }} </td>
				   		@if($ticket->priority == "low")
				   			<td class="priority text-center"><b class="alert-success ">{{ $ticket->priority }}</b></td>
				   		@elseif($ticket->priority == "high")
				   			<td class="priority text-center"><b class="alert-warning">{{ $ticket->priority }}</b></td>
				   		@else
				   			<td class="priority text-center"><b class="alert-danger">{{ $ticket->priority }}</b></td>
				   		@endif
				   		<td class="text-center">
				   		@if (Auth::user()->type == "admin")

						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
								@if($ticket->is_spam == 0)
						   			<a onclick='spam({{ $ticket->id }})'>Spam</a>|
								@else
						   			<a onclick='unspam({{ $ticket->id }})'>unSpam</a>|
								@endif



								@if($ticket->status == 'open')
						   			<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>|
								@else
						   			<a onclick='openTeckit({{ $ticket->id }})'>Open</a>|
								@endif
						   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
						   		></a>

						   	
						@else

						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						  
								@if($ticket->status == 'open')
						   			<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>|
								@else
						   			<a onclick='openTeckit({{ $ticket->id }})'>Open</a>"></a>
								@endif
						@endif

				   		</td>
				   </tr>
			  @endforeach
		  
		</table>
		 <script type="text/javascript" src="/js/tickets_index.js"></script>
