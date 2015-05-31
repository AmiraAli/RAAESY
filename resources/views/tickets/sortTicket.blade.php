@if (Auth::user()->type === "admin")
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<table class="table table-condensed">
		<tr>
			<td>Subject</td>
			<td class="discription">Description</td>
			<td class="category">Category</td>
			<td>File Attached</td>
			<td class="priority">Periorty</td>
			<td>Action</td>
		</tr>
		  @foreach($tickets as $ticket)
			   <tr id="{{ $ticket->id }}">
			   		<td>{{ $ticket->subject->name }}</td>
			   		<td class="discription">{!! $ticket->description !!}</td>
			   		<td class="category">{{ $ticket->category->name }}</td>
			   		<td >{{ $ticket->file }}</td>
			   		<td class="priority">{{ $ticket->priority }}</td>
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
@endif