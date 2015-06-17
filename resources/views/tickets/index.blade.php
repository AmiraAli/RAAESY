@extends('app')
@section('content')
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href="/css/searchticket.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">	
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<br>
<div class="container">


<input type="hidden" id="auth" value=
"<?php
if($current_user->type=='admin'){
	echo 1;
}else{
	echo 0;
}
?>">
	
	<div class="col-md-12">
		<div class="col-md-3">
		</div>
		
		<div class="col-md-3">
			@if(Auth::user()->type=="admin" or Auth::user()->type=="regular" )
				<div id="new-ticket">
					@if(Auth::user()->type=="admin" )
						<a  href="{{ url('/tickets/exportCSV') }}" > <img src="/images/CSV.png" style="width:40px"></a>
					@endif
					<a class="btn navbtn txtnav hv" href="{{ url('/tickets/create') }}"> New Ticket</a>
				</div>
			@endif
		</div>

		<div class="col-md-6">
			<div id="search">
				<div class="input-group">   		
			       <input type="Search" placeholder="subject...." id="searchticket" class="form-control" /> 
			       <div class="input-group-btn">
						<button class="btn navbtn txtnav hv" onclick="SearchButton()" >
						   	<span class="glyphicon glyphicon-search"></span>
					   	</button>
				    </div>
				</div>
			</div>		
		</div>

	</div>	

	<br><br><br>

	<div class="col-md-12">	
		<div class="row-fluid" id="icons_list">
		    <div class="span12">
				<ul class="nav nav-pills" role="tablist">
					@if(Auth::user()->type === "admin")
					  <li role="presentation" id="unanswered"><a href="#" onclick="searchTicket('unanswered', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)" >Unanswered <span id="unansweredCount" class="badge">{{ count($unanswered) }}</span></a></li>
					  <li role="presentation" id="unassigned"><a href="#" onclick="searchTicket('unassigned', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">Unassigned <span id="unassignedCount" class="badge">{{ $unassigned[0]->count }}</span></a></li>
					  <li role="presentation" id="expired"><a href="#" onclick="searchTicket('expired', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">Deadline exceeded <span id="expiredCount" class="badge">{{ $expired[0]->count }}</span></a></li>
					@endif
					  <li role="presentation" id="open"><a href="#" onclick="searchTicket('open', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">Unclosed <span id="openCount" class="badge">{{ $open[0]->count }}</span></a></li>	  
					  <li role="presentation" id="closed"><a href="#" onclick="searchTicket('closed', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">Closed <span id="closedCount" class="badge">{{ $closed[0]->count }}</span></a></li>
					  <li role="presentation" class="active" id="all"><a href="#" onclick="searchTicket('all', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">All(including closed) <span id="allCount" class="badge">{{ $allcount }}</span></a></li>
					@if(Auth::user()->type === "admin")
					  <li role="presentation" id="spam"><a href="#" onclick="searchTicket('spam', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">Spam <span id="spamCount" class="badge">{{ $spam[0]->count }}</span></a></li>	
					@endif
				</ul>
			</div>
		</div>
	</div>

	<br><br><br>
	<div class="col-xs-12">	
	         
		<div class="col-md-3 col-xs-12">

			<div class="row">
				@if(Auth::user()->type === "admin")
					

					<div class="panel ">
						<div class="panel-heading navbtn txtnav">
							<a  class="txtnav  hv" href="#" id="toggle" style="text-decoration:none;" ><strong>AdvancedSearch              
							<span class="glyphicon glyphicon-search"></span></strong></a>
						</div>

					  	<div class='panel-body advancedSearchDiv'>

							<form class= "form-horizontal" onsubmit="return false">	   
							   <div class="form-group">
									<label class="col-md-3 control-label">Priority</label>
								   	<div class="col-md-7">
									    <select class="form-control" id='ticketPriority'>
											<option value="">All</option>
											<option value="low">low</option>
											<option value="high">high</option>
											<option value="critical">critical</option>
										</select>
									</div>	
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">From</label>
								   	<div class="col-md-7">				    
							   			<input type="text" name="from" class="form-control" id='ticketStartDate' />     
							   		</div>	
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">To</label>
								   	<div class="col-md-7">
								   		<input type="text" name="to" class="form-control" id='ticketEndDate' />     	
								   	</div>	
								</div>
								 <div class="form-group">
									<label class="col-md-3 control-label">Technical</label>
								   	<div class="col-md-7">
							    		<select id='ticketTechnical' class="form-control">
											<option>All</option>
											@foreach($technicals as $technical)
												<option id="{{$technical->id}},technical">{{$technical->fname}} {{$technical->lname}}</option>
											@endforeach
										</select>
									</div>	
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" onclick='AdvancedSearch()' class="btn navbtn txtnav advancedsearchbuttonwithall">Search</button>
									</div>	
								</div>
							</form> 	
					  	</div>
					</div>
				@endif
			</div>


			<div class="row" id="category_list">
				<div class="list-group">
					<a href="#" class="list-group-item active" id="cat_all" onclick="searchByCat('cat_all', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ $allcount }}</span><strong>All categories</strong></a>
					@foreach ($categories as $category)
						   <a href="#" class="list-group-item" id="cat_{{ $category->category_id }}" onclick="searchByCat('cat_{{ $category->category_id }}', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ $category->count }}</span>{{ $category->name }}</a>  			         
				    @endforeach


				  
				</div>
			</div>

			<div class="row" id="sort_list">
				<div class="panel ">
					<div class="panel-heading navbtn txtnav">
						<h3 class="panel-title txtnav">Sort By</h3>
					</div>
					<div class="panel-body">
						<div class="form-group" style="display:inline;">
							<div class="col-md-8">
								<select class="form-control" name="sort" id="sortBy" onchange="sortBy(<?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)">						
								<option value="subject">Subject</option>
								<option value="created_at">Create Date</option>
								@if(Auth::user()->type != "regular")
								<option value="deadline">Deadline</option>					
								<option value="priority">Priority</option>				
								@endif	
								</select>
							</div>
						</div>
						<button class="btn navbtn txtnav hv" id="sortType" onclick="sortType(<?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)" style="display:inline;">DESC</button>
					
						<br>

						<div class="form-group container">
							<br>
							<a href="javascript:;" id="selectFields" style="text-decoration:none;">Select Column To Show</a>

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
								@if(Auth::user()->type != "regular")
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
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			@if(Auth::user()->type === "admin")
				<div class="row">
					<div class="panel ">
						<div class="panel-heading navbtn txtnav">
							<h3 class="panel-title">Tags</h3>
						</div>
						<div class="panel-body">
							<div class="form-group" style="display:inline;">
								<div class="col-md-8">
									<select class="form-control" name="tag" id="tag" onchange="tag()">
									<option value="">Select Tag</option>	
									@foreach ($tags as $tag)				
									<option value="{{$tag->id}}">{{$tag->name}}</option>
										@endforeach					
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
		<div class="col-md-9 col-xs-12">
			<div id="table_show">
				<table class="table table-hover">
					<thead>
						<tr class="navbtn txtnav">	
							<td class="subject text-center">Subject</td>
							<td class="status text-center">Status</td>
							<td class="category text-center">Category</td>
							<td class="created_at text-center">Creation date</td>
							@if(Auth::user()->type != "regular")
							<td class="deadline text-center">Dead line</td>
							<td class="priority text-center">Periorty</td>
							@endif
							<td class="setting text-center">Settings</td>
						</tr>
					</thead>
					<tbody>
						@foreach($tickets as $ticket)
							<tr id="{{ $ticket->id }}">   		
						   		<td class="subject text-center"><a href='/tickets/{{ $ticket->id }}'><b>{{ $ticket->subject->name }}</b></a></td>
						   		<td id="{{ $ticket->id }}status" class="status text-center"> {{ $ticket->status }}</td>
						   		<td class="category text-center">{{ $ticket->category->name }}</td>
						   		<td class="created_at text-center">{{ $ticket->created_at }} </td>
						   		@if(Auth::user()->type != "regular")
							   		<td class="deadline text-center">{{ $ticket->deadline }} </td>
							   		@if($ticket->priority == "low")
							   			<td class="priority text-center"><b class="alert-success ">{{ $ticket->priority }}</b></td>
							   		@elseif($ticket->priority == "high")
							   			<td class="priority text-center"><b class="alert-warning">{{ $ticket->priority }}</b></td>
							   		@else
								   		<td class="priority text-center"><b class="alert-danger">{{ $ticket->priority }}</b></td>
								   	@endif
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
									   			<a onclick='closeTeckit({{ $ticket->id }},{{ $ticket->is_spam }},1)'>Close</a>|
											@else
									   			<a onclick='openTeckit({{ $ticket->id }},{{ $ticket->is_spam }},1)'>Open</a>|
											@endif
									   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
									   		></a>

									   	
									@elseif(Auth::user()->type == "regular")

									   		<a id="{{ $ticket->id }}popup" href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
									   		data-content=
									   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
									   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
											@if($ticket->status == 'open')
									   			<a onclick='closeTeckit({{ $ticket->id }},0,2)'>Close</a>|
											@else
									   			<a onclick='openTeckit({{ $ticket->id }},0,2)'>Open</a>@endif"></a>
											
									@else
										<a id="{{ $ticket->id }}popup" href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
									   		data-content=
									   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|						  
											@if($ticket->status == 'open')
									   			<a onclick='closeTeckit({{ $ticket->id }},0,3)'>Close</a>|
											@else
									   			<a onclick='openTeckit({{ $ticket->id }},0,3)'>Open</a>@endif"></a>
									@endif


						   	</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!!  $ticketPag->render() !!}

					<div>
</div>

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
 <script type="text/javascript" src="/js/toggleadvacedsearch.js"></script>


 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>

<script >
    $(document).ready(function() {
        $('#ticketStartDate').datetimepicker({
            format:'Y-m-d H:00:00',
              });
        $('#ticketEndDate').datetimepicker({
            format:'Y-m-d H:59:59',
              });
 });
 </script>

@endsection