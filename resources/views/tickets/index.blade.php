@extends('app')
@section('content')
<script type="text/javascript" src="/js/ticket_delete.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">
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
			   		<td>{!! $ticket->description !!}</td>
			   		<td>{{ $ticket->category->name }}</td>
			   		<td>{{ $ticket->file }}</td>
			   		<td>{{ $ticket->priority }}</td>
			   		<td>
			   			<!-- Trigger the modal with a button -->
  					<a  data-toggle="modal" data-target="#myModal">action</a>
					  <!-- Modal -->
					  <div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog">
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Actions</h4>
					        </div>
					        <div class="modal-body">
					          <ul>
					          <li><a href="/tickets/{{ $ticket->id }} ">Show</a></li>
					          <li><a href="/tickets/{{ $ticket->id }}/edit">Edit</a></li>
					          <li><a onclick="Delete({{ $ticket->id }})" data-dismiss="modal">Delete</a></li>
					          </ul>
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        </div>
					      </div>
					      
					    </div>
					  </div>
			   		</td>
			   </tr>
		  @endforeach
	  
	</table>

</div>
</div>
</div>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
@endsection
