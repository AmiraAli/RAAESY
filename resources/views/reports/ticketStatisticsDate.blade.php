<br>
<div class="raw">
		<div class="col-md-5"  id="customedate">
			From:<input type="date" id="startdate" value={{$startdate}}>
			To:<input type="date" id="enddate" value={{$enddate}}>
		</div>
		<div style="float:left;">
			<button class="btn navbtn txtnav" onclick="searchDate()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
<!--csv report-->
		<a  id="csv" href="/reports/problemMangementCSV">
		    <img src="/images/CSV.png" style="width:40px"></img>
		</a>
</div>
	@if (Session::get('lang') =="ar")
		<a  href="/reports/problemMangement?lang=en" class="btn navbtn txtnav pull-right" >English</a>
	@else
		<a  href="/reports/problemMangement?lang=ar" class="btn navbtn txtnav pull-right" >عربى</a>
	@endif
	<br><br>
	<?php
	if (empty(json_decode(json_encode($allTickets), true)))
	{
		echo "<h2 class='navtxt'> No Tickets within this range of date!!</h2>";
	}else{
	?>
		@foreach($allTickets as $allTicket)

	<table class="table table-hover" >
		<thead>
		<tr class="navbtn txtnav">
			<th>{{trans('problemmangement.subject')}}</th>
			<th>{{trans('problemmangement.total ticket count')}}</th>
			<th>{{trans('problemmangement.total ticket solved')}}</th>
			<th>{{trans('problemmangement.percentages')}}</th>
		</tr>
		</td>
		<tbody>
		@if ($allTicket->percentage < 25)
		  	<tr style="background:rgba(240,96,86,0.85); color:#FFF;">
		@else
			<tr>
		@endif
				<td>{{$allTicket->subject->name}}</td>
				<td>{{$allTicket->allticket}}</td>
				<td>{{$allTicket->closedcount}}</td>
				<td>{{$allTicket->percentage}}%</td>
			</tr>
		</tbody>
	</table>

			<div class="panel panel-default">
			<div class="panel-body" style="background:#bce0ee;">
			<div class="col-md-3">
				<h4>Tickets Id</h4>
				@foreach($allTicket->ids as $id)
					#{{$id}}<br>
				@endforeach
			</div>
			<div class="col-md-3">
				<h4>Tickets Section/category</h4>
				@foreach($allTicket->sectionCategory as $section)
					{{$section}}<br>
				@endforeach
			</div>
	</div>
			
			</div>
			
		@endforeach
<?php
}
?>
 <script type="text/javascript" src="/js/reports/problemmangement.js"></script>
 <script type="text/javascript" src="/js/reports/lang.js"></script>
