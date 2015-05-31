
@extends('app')
@section('content')
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">

<!------------------------------- search------------------------------------------------------------------------------------------->
<div class="row" id="search">
	<form action="" class="navbar-form navbar-right">
	   <div class="input-group">

	        <input type="Search" placeholder="Search..." id="searchticket" class="form-control" /> 
	       <div class="input-group-btn">
		   <button class="btn btn-info" >
		   <span class="glyphicon glyphicon-search"></span>
		   </button>
	       </div>
	   </div>
	</form>
</div>
<!-- table---------------------------------------------------------------------------------------------------------->

<div class="row" id="icons_list">

	<ul class="nav nav-pills" role="tablist">
	  <li role="presentation" id="unanswered"><a href="#" onclick="searchTicket('unanswered')">Unanswered <span class="badge">{{ count($unanswered) }}</span></a></li>
	  <li role="presentation" id="unassigned"><a href="#" onclick="searchTicket('unassigned')">Unassigned <span class="badge">{{ count($unassigned) }}</span></a></li>
	  <li role="presentation" id="expired"><a href="#" onclick="searchTicket('expired')">Deadline exceeded <span class="badge">{{ count($expired) }}</span></a></li>
	  <li role="presentation" id="open"><a href="#" onclick="searchTicket('open')">Unclosed <span class="badge">{{ count($open) }}</span></a></li>	  
	  <li role="presentation" id="closed"><a href="#" onclick="searchTicket('closed')">Closed <span class="badge">{{ count($closed) }}</span></a></li>
	  <li role="presentation" id="all" class="active" onclick="searchTicket('all')"><a href="#">All(including closed) <span class="badge">{{ count($allTickets) }}</span></a></li>
	  <li role="presentation" id="spam"><a href="#" onclick="searchTicket('spam')">Spam <span class="badge">{{ count($spam) }}</span></a></li>	
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

<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								<select class="form-control" name="sort" id="sortBy">
								<option value="">Sort By</option>							
								<option value="1">Subject</option>
								<option value="2">Deadline</option>
								<option value="3">Create Date</option>
								<option value="4">priority</option>
									
								</select>
							
							</div>
						</div>

<?php 

//  $result = array();
//         foreach ($tickets as $key => $value)
//         {
//             $result[$key] = $value;
//         }
// 	    	//file_put_contents("/home/eman/"."aaaaa.html", $result);

// function cmp($a, $b)
// {
//     return strcmp($a->priority, $b->priority);
// }

// usort($result, "cmp");

?>
</div>

</div>

<div class="col-md-9 "  id="table_show">

	<table class="table table-condensed">
			<tr>
				<td> ID </td>
				<td>Subject</td>
				<td>Status</td>
				<td>Category</td>
				<td>Periorty</td>
				<td>Settings</td>
			</tr>
			  @foreach($allTickets as $ticket)
				   <tr id="{{ $ticket->id }}">
				   		<td>#{{ $ticket->id }} </td>
				   		<td>{{ $ticket->subject->name }}</td>
				   		<td> {{ $ticket->status }}</td>
				   		<td>{{ $ticket->category->name }}</td>
				   		@if($ticket->priority == "low")
				   			<td><b class="alert-success">{{ $ticket->priority }}</b></td>
				   		@elseif($ticket->priority == "high")
				   			<td><b class="alert-warning">{{ $ticket->priority }}</b></td>
				   		@else
				   			<td><b class="alert-danger">{{ $ticket->priority }}</b></td>
				   		@endif
				   		<td>
				   		@if (Auth::user()->type == "admin")
					   		@if($ticket->status == 'open')
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='spam({{ $ticket->id }})'>Spam</a>|
						   		<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>|
						   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
						   		></a>
						   	@else
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='spam({{ $ticket->id }})'>Spam</a>|
						   		<a onclick='openTeckit({{ $ticket->id }})'>Open</a>|
						   		<a onclick='Delete({{ $ticket->id }})'>Delete</a>"
						   		></a>
						   	@endif
						@else
							@if($ticket->status == 'open')
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='closeTeckit({{ $ticket->id }})'>Close</a>"
						   		></a>
						   	@else
						   		<a href="#" class="glyphicon glyphicon-plus-sign" data-toggle="popover" data-trigger="focus" 
						   		data-content=
						   		"<a href='/tickets/{{ $ticket->id }}'>Show</a>|
						   		<a href='/tickets/{{ $ticket->id }}/edit'>Edit</a>|
						   		<a onclick='openTeckit({{ $ticket->id }})'>Open</a>"
						   		></a>
						   	@endif
						@endif

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
 <script type="text/javascript" src="/js/search_ticket_by_subject.js"></script>
 <script type="text/javascript" src="/js/ticket_search.js"></script>


 <script >
		
window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
            
$( "#sortBy" ).change(function() 
{

var tickets = JSON.parse('<?php echo json_encode($tickets) ?>');

		   $.ajax({
			    url: '/tickets/sortTicket',
			    type: 'post',
			    data: { data : tickets , sortType: $('#sortBy option:selected').text() },
			    success: function(result) {
					 $('#table_show').html(result);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});


		
});
</script>
@endsection
