@if (Auth::user()->type === "admin")
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<table class="table table-condensed">
			<tr>
				<td> ID </td>
				<td>Subject</td>
				<td>Status</td>
				<td class="category">Category</td>
				<td class="priority">Periorty</td>
				<td>Settings</td>
			</tr>
			  @foreach($tickets as $ticket)
				   <tr id="{{ $ticket->id }}">
				   		<td>#{{ $ticket->id }} </td>
				   		<td>{{ $ticket->subject->name }}</td>
				   		<td> {{ $ticket->status }}</td>
				   		<td class="category">{{ $ticket->category->name }}</td>
				   		@if($ticket->priority == "low")
				   			<td class="priority"><b class="alert-success ">{{ $ticket->priority }}</b></td>
				   		@elseif($ticket->priority == "high")
				   			<td class="priority"><b class="alert-warning">{{ $ticket->priority }}</b></td>
				   		@else
				   			<td class="priority"><b class="alert-danger">{{ $ticket->priority }}</b></td>
				   		@endif
				   		<td>
				   		@if (Auth::user()->type == "admin")
					   		@if($ticket->status == 'open')
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='spam({{ $ticket->id }})'>Spam</a>|
						   		<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>|
						   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
						   		></a>
						   	@else
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='spam({{ $ticket->id }})'>Spam</a>|
						   		<a onclick='openTeckit({{ $ticket->id }})'>Open</a>|
						   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
						   		></a>
						   	@endif
						@else
							@if($ticket->status == 'open')
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>"
						   		></a>
						   	@else
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='openTeckit({{ $ticket->id }})'>Open</a>"
						   		></a>
						   	@endif
						@endif

				   		</td>
				   </tr>
			  @endforeach
		  
		</table>
@endif
		 <script type="text/javascript" src="/js/tickets_index.js"></script>