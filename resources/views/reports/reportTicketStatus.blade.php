<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

@extends('app')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/js/reports/reportTicketStatus.js"></script>

@if (Session::get('lang') =="ar")
	<a  href="/reports/reportTicketStatus?lang=en" class="btn navbtn txtnav" >English</a>
@else
	<a  href="/reports/reportTicketStatus?lang=ar" class="btn navbtn txtnav" >عربى</a>
@endif


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
		<th> </th>
		<th>{{ trans('words.id')}}</th>
		<th>{{ trans('words.subject') }}</th>
		<th>{{ trans('words.Current_Status')}}</th>
		<th>{{ trans('words.No_of_Open')}}</th>
		<th>{{ trans('words.No_of_Close')}}</th>
		<tbody id="tbody">
			@foreach($tickets as $ticket)
		  <tr>
         <td>
<a href="#" class='glyphicon glyphicon-triangle-right' onclick='toggle({{$ticket->id}})'></a>	</td>	  
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
					@foreach($ticketStatuses as $ticketStatus)
		  <tr class="text-center {{$ticket->id}}" >	

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
			@endforeach
		</tbody>
		</table>
		<!-- <a href="http://localhost:8000/reports/reportTicketStatus"> download </a> -->


		<!--?php echo file_get_contents('http://localhost:8000/reports/reportTicketStatus'); ?-->
<!-- 	<a onclick="this.href='data:text/html;charset=UTF-8,'+encodeURIComponent(document.documentElement.outerHTML)" href="#" download="page.html">Download</a>
 -->

<a href="//pdfcrowd.com/url=http://localhost:8000/reports/reportTicketStatus">Save to PDF</a>

<!-- CSV -->
<a href="/reports/exportTicketStatusReport" class="btn btn-primary">Export as CSV</a>
 @endsection


</body>
</html>