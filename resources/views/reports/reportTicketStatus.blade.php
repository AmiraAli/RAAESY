@extends('app')

@section('content')
<style>
	#con{
		border:none !important;
	}
</style>
<link href="/css/sections/sectionIndex.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/js/reports/reportTicketStatus.js"></script>
<div class="container">
    <h3 class="navtxt"><a href="{{ url('/reports')}}"> Reports</a>
    >>Tickets History</h3>
</div>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<div class="container">

<br>
<div class="row pull-right">
<!-- CSV -->
<a href="/reports/exportTicketStatusReport"><img src="/images/CSV.png" style="width:40px"></a>

</div>
<div id="con">
<center><?php echo $tickets->render(); ?></center>
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


<br><br>
	<div  class="row">
		<table class="table table-hover">
		<thead>
		<tr class="navbtn txtnav">
		<th></th>
		<th>{{ trans('words.id')}}</th>
		<th>{{ trans('words.subject') }}</th>
		<th>{{ trans('words.Current_Status')}}</th>
		<th>{{ trans('words.No_of_Open')}}</th>
		<th>{{ trans('words.No_of_Close')}}</th>
		</tr>
		</thead>
		<tbody id="tbody">
			@foreach($tickets as $ticket)
		  <tr>
         <td>
<a href="#" class='glyphicon glyphicon-triangle-right' onclick='toggle({{$ticket->id}})'></a>
</td>	  
					<td>#{{$ticket->id}}</td>
					<td>{{$ticket->subject->name}}</td>
					@if($ticket->status=='open')
					<td>{{ trans('words.open')}}</td>
					@else
					<td>{{ trans('words.close')}}</td>
					@endif
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
		  <tr>
		  <td class="text-center">
		  <table class="table table-hover " >
					@foreach($ticketStatuses as $ticketStatus)
		  <tr class="{{$ticket->id}}" style="display:none; background:#bce0ee;" >	

						@if($ticketStatus->ticket_id==$ticket->id)
						   @if($ticketStatus->value=='open')
							<td class="text-center">{{ trans('words.open')}}</td>
							@else
							<td class="text-center">{{ trans('words.close')}}</td>
							@endif
							<td class="text-center">{{$ticketStatus->created_at}}</td>
							
						@endif

		  </tr>				
					@endforeach
			</table>
			</td>
			</tr>
			@endforeach
		</tbody>
		</table>
</div>
</div>
</div>

 @endsection
