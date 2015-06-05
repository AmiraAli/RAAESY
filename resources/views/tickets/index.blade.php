

@extends('app')
@section('content')
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href="/css/searchticket.css" rel="stylesheet">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">


<!------------------------------- search------------------------------------------------------------------------------------------->
<div class="row" id="search">

	   <div class="input-group">

			   		
	        <input type="Search" placeholder="subject...." id="searchticket" class="form-control" /> 
	       <div class="input-group-btn">
		   <button class="btn btn-info" onclick="SearchButton()" >
		   <span class="glyphicon glyphicon-search"></span>
		   </button>


	       </div>
	   </div>


	
</div>
<!-- table---------------------------------------------------------------------------------------------------------->
@if(Auth::user()->type=="admin" or Auth::user()->type=="regular" )
	<div class="row">
	<a class="btn btn-primary" href="{{ url('/tickets/create') }}"> New Ticket</a>
	@if(Auth::user()->type=="admin" )
		<a  href="{{ url('/tickets/exportCSV') }}" > <img src="/images/CSV.png" style="width:40px"></a>
	@endif
	</div>
@endif
<div class="row" id="icons_list">

	<ul class="nav nav-pills" role="tablist">
		@if(Auth::user()->type === "admin")
		  <li role="presentation" id="unanswered"><a href="#" onclick="searchTicket('unanswered')">Unanswered <span class="badge">{{ count($unanswered) }}</span></a></li>
		  <li role="presentation" id="unassigned"><a href="#" onclick="searchTicket('unassigned')">Unassigned <span class="badge">{{ count($unassigned) }}</span></a></li>
		  <li role="presentation" id="expired"><a href="#" onclick="searchTicket('expired')">Deadline exceeded <span class="badge">{{ count($expired) }}</span></a></li>
		@endif
		  <li role="presentation" id="open"><a href="#" onclick="searchTicket('open')">Unclosed <span class="badge">{{ count($open) }}</span></a></li>	  
		  <li role="presentation" id="closed"><a href="#" onclick="searchTicket('closed')">Closed <span class="badge">{{ count($closed) }}</span></a></li>
		  <li role="presentation" id="all" class="active" onclick="searchTicket('all')"><a href="#">All(including closed) <span class="badge">{{ count($tickets) }}</span></a></li>
		@if(Auth::user()->type === "admin")
		  <li role="presentation" id="spam"><a href="#" onclick="searchTicket('spam')">Spam <span class="badge">{{ count($spam) }}</span></a></li>	
		@endif
	</ul>
</div>

<br>

<div class="row">

<div class="col-md-3 ">

<div class="row" id="category_list">


<div class="list-group">
	<a href="#" class="list-group-item active" id="cat_all" onclick="searchByCat('cat_all')"><strong>All categories</strong></a>
	@foreach ($sections as $section)
		<a href="#" class="list-group-item" id="sec_{{ $section->id }}" onclick="searchByCat('sec_{{ $section->id }}')"> &nbsp &nbsp<strong>{{ $section->name }}</strong></a>
		@foreach ($section->categories as $category)
			<a href="#" class="list-group-item" id="cat_{{ $category->id }}" onclick="searchByCat('cat_{{ $category->id }}')"> &nbsp &nbsp &nbsp &nbsp{{ $category->name }}</a>
		@endforeach	        			         
    @endforeach
  
</div>


</div>

<div class="row" id="sort_list">

	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">Sort By</h3>
		</div>
		<div class="panel-body">
			<div class="form-group" style="display:inline;">
				<div class="col-md-8">
					<select class="form-control" name="sort" id="sortBy" onchange="sortBy()">						
					<option value="subject">Subject</option>
					<option value="deadline">Deadline</option>
					<option value="created_at">Create Date</option>
					<option value="priority">Priority</option>							
					</select>
				</div>
			</div>
			<button class="btn btn-info" id="sortType" onclick="sortType()" style="display:inline;">DESC</button>
		</div>
		<br>
		<div class="form-group container">
<a href="javascript:;" id="selectFields">Select Column To Show</a>
		<br>
		<div style="display:none" id="check">

			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="subject" checked >
				Subject
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="status" checked >
				Status
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="category" checked >
				Category
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="created_at" checked >
				Created Date
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="deadline" checked >
				Deadline
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="priority" checked >
				Priority
			</label>
			</div>
			</div>
		</div>
	</div>

	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">Tags</h3>
		</div>
		<div class="panel-body">
			<div class="form-group" style="display:inline;">
				<div class="col-md-8">
					<select class="form-control" name="tag" id="tag" onchange="tag()">
					<option value="">Select Tag</option>	
					@foreach ($tags as $tag)				
					<option value="{{$tag->name}}">{{$tag->name}}</option>
						@endforeach					
					</select>
				</div>
			</div>
		
			</div>
		</div>
	</div>


<button id="toggle" class="glyphicon glyphicon-glass"></button>

	<div class="panel panel-default advancedSearchDiv">
	  <div class='panel-heading'>AdvancedSearch</div>
	  <div class='panel-body'>
	  @if(Auth::user()->type === "admin")
	   Priority: <select id='ticketPriority'>
		<option></option>
		<option>low</option>
		<option>high</option>
		<option>critical</option>
					</select><br><br>
	   From: <input id='ticketStartDate' type='date'><br><br> 
	   To: <input id='ticketEndDate' type='date'><br><br>
	   Technical Name: <select id='ticketTechnical'>
		<option></option>
		@foreach($technicals as $technical)
			<option id="{{$technical->id}},technical">{{$technical->fname}} {{$technical->lname}}</option>
		@endforeach
			</select><br><br>
		<button onclick='AdvancedSearch()' class="btn btn-primary advancedsearchbuttonwithall">Search</button>
	 	@endif
	  </div>
	</div>
</div>


<div class="col-md-9 "  id="table_show">
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
			  @foreach($tickets as $ticket)
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

</div>
</div>
</div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="/js/tickets_index.js"></script>
 <script type="text/javascript" src="/js/autocomplete_serach_tickets.js"></script>
 <script type="text/javascript" src="/js/search_ticket_by_subject.js"></script>
  <script type="text/javascript" src="/js/ticket_search.js"></script>
 <script type="text/javascript" src="/js/ticket_advanced_search.js"></script>
 <script type="text/javascript" src="/js/toggleadvacedsearch.js"></script>

@endsection
