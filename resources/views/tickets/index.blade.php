
@extends('app')
@section('content')


<script type="text/javascript" src="/js/ticket_delete.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">

<!-- search-->

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

	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">Sort By</h3>
		</div>
		<div class="panel-body">
			<div class="form-group" style="display:inline;">
				<div class="col-md-8">
					<select class="form-control" name="sort" id="sortBy">						
					<option value="subject">Subject</option>
					<option value="deadline">Deadline</option>
					<option value="created_at">Create Date</option>
					<option value="priority">Priority</option>							
					</select>
				</div>
			</div>
			<button class="btn btn-info" id="sortType" style="display:inline;">ASC</button>
		</div>
		<br>
		<div class="form-group container">
<a href="javascript:;" id="selectFields">Select Column To Show</a>
		<br>
		<div style="display:none" id="check">
		<div class="checkbox" >
			<label>
				<input type="checkbox" class="checkbox1" value="discription" checked >
				discription
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="category" checked >
				category
			</label>
			</div>
			<div class="checkbox">
			<label>
				<input type="checkbox"  class="checkbox1" value="priority" checked >
				priority
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
					<select class="form-control" name="tag" id="tag">
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

</div>

<div class="col-md-9 "  id="table_show">

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

</div>
</div>
</div>



 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="/js/tickets_index.js"></script>
 <script type="text/javascript" src="/js/autocomplete_serach_tickets.js"></script>
 
 
<script>
$( "#selectFields" ).click(function() {
  $( '#check' ).slideToggle( "fast" );
});


  $('.checkbox1').change(function() {
        if(!$(this).is(":checked")) 
        {
            $('.'+$(this).val()).hide();
        }
        else
        {
        	$('.'+$(this).val()).show();
        }
    });
</script>

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
	    data: { data : tickets , sortBy: $('#sortBy ').val() , sortType : "DESC"},
	    success: function(result) {
			 $('#table_show').html(result);
			 $("#sortType").html("ASC");

			$('.checkbox1').each(function () {
				 if(!$(this).is(":checked")) 
			        {
			        	
			            $('.'+$(this).val()).hide();

			        }
			        else
			        {
			        
			        	$('.'+$(this).val()).show();
			        }
			    
			});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});

		
});

$("#sortType").click(function(){

	var tickets = JSON.parse('<?php echo json_encode($tickets) ?>');

   $.ajax({
	    url: '/tickets/sortTicket',
	    type: 'post',
	    data: { data : tickets , sortBy: $('#sortBy ').val() , sortType : $("#sortType").text()},
	    success: function(result) {
			 $('#table_show').html(result);

			 if ($("#sortType").text() == "ASC")
			 {
			 	$("#sortType").html("DESC");
			 } 
			 else
			 {
			 	$("#sortType").html("ASC")
			 };
			 $('.checkbox1').each(function () {
			 if(!$(this).is(":checked")) 
		     {
		        	
		       $('.'+$(this).val()).hide();

		     }
		     else
		     {
		        
		        $('.'+$(this).val()).show();
		     }
    
});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});
    
});

$( "#tag" ).change(function() 
{
var tickets = JSON.parse('<?php echo json_encode($tickets) ?>');

    $.ajax({
	    url: '/tickets/relatedTag',
	    type: 'post',
	    data: { data : tickets , tagId : $('#tag').val() },
	    success: function(result) {
			 $('#table_show').html(result);
			 $('.checkbox1').each(function () {
				 if(!$(this).is(":checked")) 
			        {
			        	
			            $('.'+$(this).val()).hide();

			        }
			        else
			        {
			        
			        	$('.'+$(this).val()).show();
			        }
			    
			});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});

		
});
</script>
@endsection
