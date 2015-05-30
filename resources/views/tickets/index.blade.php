@extends('app')
@section('content')
<script type="text/javascript" src="/js/ticket_delete.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
hhhhhhhhhhhh
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
