@extends('app')

@section('content')

<link href="/css/assets/show.css" rel="stylesheet">

<div class="container">
	<div id="asset-info">
		<strong>Model :</strong>
			{{ $asset->name }}
			<br><br>
		<strong>Manufacturer :</strong>
			{{ $asset->manufacturer }}
			<br><br>
		<strong>Type :</strong>
			{{ $asset->assettype->name }}
			<br><br>
		<strong>Serial Number :</strong>
			{{ $asset->serialno }}
			<br><br>
		<strong>Belongs To :</strong>
			{{ $asset->user->fname }} {{ $asset->user->lname }}
			<br><br>
		<strong>Location :</strong>
			{{ $asset->location }}
			<br><br>
	

		<h2>Related Tickets</h2>

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
</div>


@endsection
