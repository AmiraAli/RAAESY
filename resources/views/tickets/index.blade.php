@extends('app')
@section('content')
<script type="text/javascript" src="/js/ticket_delete.js"></script>
<div class="container">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="row" id="search">
 hiiii first
</div>

<div class="row" id="icons_list">
hiiii second
</div>

<div class="row">

<div class="col-md-3 ">

<div class="row" id="category_list">
hiiiiiiiiiii category
</div>

<div class="row" id="sort_list">
hiiiiiii sort
</div>

</div>

<div class="col-md-9 "  id="table_show">
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

</div>

</div>

	
</div>
@endsection