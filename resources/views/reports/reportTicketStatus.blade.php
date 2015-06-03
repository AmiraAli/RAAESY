@extends('app')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/js/reports/reportTicketStatus.js"></script>
<?php $open= array(); $close= array(); ?>
	@foreach($tickets as $ticket)
		<?php $countOpen=0; $countClose=0; ?>
		@foreach($ticketStatuses as $ticketStatus)
				  			
				@if($ticketStatus->ticket_id==$ticket->id)
					@if($ticketStatus->value=='open')
						<?php 
							$countOpen=$countOpen+1;
							$open[$ticket->id]=$countOpen; 
						?>
					@endif
					@if($ticketStatus->value=='close')
						<?php
							$countClose=$countClose+1;
							$close[$ticket->id]=$countClose; 
						 ?>
					@endif
				@endif	

		@endforeach	

	@endforeach



	<div  class="container">
		<table class="table table-hover "> 
		<th>id</th>
		<th>subject</th>
		<th>Current Status</th>
		<th>No of Open</th>
		<th>No of Close</th>
		<tbody id="tbody">
			@foreach($tickets as $ticket)
		  <tr>
         <td>
<a href="#" class='glyphicon glyphicon-triangle-right' onclick='toggle({{$ticket->id}})'></a>	</td>	  
					<td>#{{$ticket->id}}</td>
					<td>{{$ticket->subject->name}}</td>
					<td>{{ $ticket->status }}</td>
					@if(!empty($open[$ticket->id]))
						<td>{{ $open[$ticket->id] }}</td>
				    @else
						<td >0</td>
					@endif
					@if(!empty( $close[$ticket->id] ))
						<td>{{ $close[$ticket->id] }}</td>
					@else
						<td>0</td>
					@endif
		  </tr>			
					@foreach($ticketStatuses as $ticketStatus)
		  <tr class="text-center {{$ticket->id}}" >	

						@if($ticketStatus->ticket_id==$ticket->id)
							<td class="text-center">{{$ticketStatus->value}}</td>
							<td class="text-center">{{$ticketStatus->created_at}}</td>
							
						@endif

		  </tr>				
					@endforeach
			@endforeach
		</tbody>
		</table>
	</div>

@endsection