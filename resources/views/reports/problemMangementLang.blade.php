<br>
<div class="raw">
		<div class="col-md-5"  id="customedate">
			{{trans('problemmangement.from')}}:<input type="text" id="startdate" value={{$startdate}}>
			{{trans('problemmangement.to')}}::<input type="text" id="enddate" value={{$enddate}}>
		</div>
		<div style="float:left;">
			<button class="btn navbtn txtnav" onclick="searchDate()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
<!--csv report-->
		<a  id="csv" href="/reports/problemMangementCSV">
		    <img src="/images/CSV.png" style="width:40px"></img>
		</a>
</div>

	<br><br>
	<?php
	if (empty(json_decode(json_encode($allTickets), true)))
	{
		echo "<h2 class='navtxt'> ".trans('problemmangement.error')."</h2>";
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
<?php
}
?>

