<table class="table table-condensed">
		<tr>
			<td>Subject</td>
			<td>Description</td>
			<td>Category</td>
			<td>File Attached</td>
			<td>Periorty</td>
			<td>Action</td>
		</tr>
		  @foreach($tickets as $ticket)
			   <tr id="{{ $ticket->id }}">
			   		<td>{{ $ticket->subject->name }}</td>
			   		<td>{!! $ticket->description !!}</td>
			   		<td>{{ $ticket->category->name }}</td>
			   		<td>{{ $ticket->file }}</td>
			   		<td>{{ $ticket->priority }}</td>
			   		<td>
			   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
			   		data-content=
			   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>
			   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>
			   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
			   		></a>
			   		</td>
			   </tr>
		  @endforeach
	  
	</table>