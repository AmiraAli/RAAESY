@extends('app')

@section('content')


<div class="container">
	<h2>Model :</h2>
			{{ $asset->name }}
		<h2>Manufacturer :</h2>
			{{ $asset->manufacturer }}
		<h2>Type :</h2>
			{{ $asset->assettype->name }}
		<h2>Serial Number :</h2>
			{{ $asset->serialno }}
		<h2>Belongs To :</h2>
			{{ $asset->user->fname }} {{ $asset->user->lname }}
		<h2>Location :</h2>
			{{ $asset->location }}
	
	<h2>related articles</h2>

		<table class="table table-condensed">
			<tr>
				<td>Subject</td>
				<td>Description</td>
				<td>Category</td>
				<td>File Attached</td>
				<td>Periorty</td>
				<td>Action</td>
			</tr>
			  @foreach ($asset->tickets as $ticket)
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


@endsection
