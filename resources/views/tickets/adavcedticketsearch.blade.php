<table class="table table-condensed">
			<tr>
				
				<td class="subject text-center">Subject</td>
				<td class="status text-center">Status</td>
				<td class="category text-center">Category</td>
				<td class="created_at text-center">Creation date</td>
				<td class="deadline text-center">Dead line</td>
				<td class="priority text-center">Periorty</td>
				<td class="setting text-center">Settings</td>
			</tr>
			  @foreach($Tickets as $ticket)
				   <tr id="{{ $ticket->id }}">
				   		
				   		<td class="subject text-center">{{ $ticket->subject->name }}</td>
				   		<td id="{{ $ticket->id }}status" class="status text-center"> {{ $ticket->status }}</td>
				   		<td class="category text-center">{{ $ticket->category->name }}</td>
				   		<td class="created_at text-center">{{ $ticket->created_at }} </td>
				   		<td class="deadline text-center">{{ $ticket->deadline }} </td>
				   		@if($ticket->priority == "low")
				   			<td class="priority text-center"><b class="alert-success ">{{ $ticket->priority }}</b></td>
				   		@elseif($ticket->priority == "high")
				   			<td class="priority text-center"><b class="alert-warning">{{ $ticket->priority }}</b></td>
				   		@else
				   			<td class="priority text-center"><b class="alert-danger">{{ $ticket->priority }}</b></td>
				   		@endif
				   		<td class="setting text-center">
				   		@if (Auth::user()->type == "admin")

						   		<a id="{{ $ticket->id }}popup" href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
								@if($ticket->is_spam == 0)
						   			<a onclick='spam({{ $ticket->id }})'>Spam</a>|
								@else
						   			<a onclick='unspam({{ $ticket->id }})'>unSpam</a>|
								@endif



								@if($ticket->status == 'open')
						   			<a onclick='closeTeckit({{ $ticket->id }},{{ $ticket->is_spam }})'>Close</a>|
								@else
						   			<a onclick='openTeckit({{ $ticket->id }},{{ $ticket->is_spam }})'>Open</a>|
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
						   			<a onclick='openTeckit({{ $ticket->id }})'>Open</a>@endif"></a>
								
						@endif

				   		</td>
				   </tr>
			  @endforeach
		  
		</table>

		 <script type="text/javascript" src="/js/tickets_index.js"></script>
