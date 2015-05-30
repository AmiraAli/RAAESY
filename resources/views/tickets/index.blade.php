
@extends('app')
@section('content')
<script type="text/javascript" src="/js/ticket_delete.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">

<!-- search-->
<div class="row" id="search">
	<form action="" class="navbar-form navbar-right">
	   <div class="input-group">
	   <input type="text" id="search" class="form-control">
	       <!-- <input type="Search" placeholder="Search..." id="search" class="form-control" /> -->
	       <div class="input-group-btn">
		   <button class="btn btn-info">
		   <span class="glyphicon glyphicon-search"></span>
		   </button>
	       </div>
	   </div>
	</form>
</div>


<!-- <div class="ui-widget">
  <label for="tags">Tags: </label>
  <input id="tags">
</div> -->

<!-- table -->

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

</div>
</div>
</div>

 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="/js/tickets_index.js"></script>
 <script type="text/javascript" src="/js/autocomplete_serach_tickets.js"></script>

@endsection
