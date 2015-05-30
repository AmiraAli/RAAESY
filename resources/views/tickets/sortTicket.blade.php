@if (Auth::user()->type === "admin")
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
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
			   		<td>{{ $ticket->description }}</td>
			   		<td>{{ $ticket->category->name }}</td>
			   		<td>{{ $ticket->file }}</td>
			   		<td>{{ $ticket->priority }}</td>
			   		<td>
			   			<a href="/tickets/{{ $ticket->id }} ">Show</a>
			   			<a href="/tickets/{{ $ticket->id }}/edit">Edit</a>
			   			<a   onclick="Delete({{ $ticket->id }})">Delete</a>
			   		</td>
			   </tr>
		  @endforeach
	  
	</table>
@endif