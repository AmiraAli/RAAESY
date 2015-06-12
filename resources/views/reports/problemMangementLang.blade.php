
<div class="raw">
		<div class="col-md-5"  id="customedate">
			From:<input type="date" id="startdate" value={{$startdate}}>
			To:<input type="date" id="enddate" value={{$enddate}}>
		</div>
@if($lang=="English")
	<button id="lang" onclick="language()" class="btn navbtn txtnav" >عربى</button>
@else
	<button id="lang" onclick="language()" class="btn navbtn txtnav" >English</button>

@endif
		<div style="float:left;">
			<button class="btn btn-primary" onclick="searchDate()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
		@foreach($allTickets as $allTicket)

	<table class="table " >
	
		<tr>
			<td>{{trans('problemmangement.subject')}}
			<td>{{trans('problemmangement.total ticket count')}}
			<td>{{trans('problemmangement.total ticket solved')}}
			<td>{{trans('problemmangement.percentages')}}
		</tr>
		  	<tr>
				<td>{{$allTicket->subject->name}}</td>
				<td>{{$allTicket->allticket}}</td>
				<td>{{$allTicket->closedcount}}</td>
				<td>{{$allTicket->percentage}}%</td>
			</tr>
			
	</table>





			<div class="panel panel-default">
			<div class="panel-body" style="background:#FFCCFF;">
			<div class="col-md-3">
				<h4>{{trans('problemmangement.ticketsid')}}</h4>
				@foreach($allTicket->ids as $id)
					#{{$id}}<br>
				@endforeach
			</div>
			<div class="col-md-3">
				<h4>{{trans('problemmangement.tickets sections/category')}}</h4>
				@foreach($allTicket->sectionCategory as $section)
					{{$section}}<br>
				@endforeach
			</div>
	</div>
			
			</div>
			
		@endforeach
 <script type="text/javascript" src="/js/reports/problemmangement.js"></script>
 <script type="text/javascript" src="/js/reports/lang.js"></script>
