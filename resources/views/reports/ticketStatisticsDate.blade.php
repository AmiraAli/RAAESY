<br>
<div class="raw">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id="customedate">
	
			<div class="form-group col-md-3">
				<label>{{trans('problemmangement.from')}}:</label>
				<input type="text" class="form-control" id="startdate" value="{{$startdate}}">
			</div>

			<div  class="col-md-3">
				<label>{{trans('problemmangement.to')}}:</label>
				<input type="text" class="form-control" id="enddate" value="{{$enddate}}">
			</div>
			<div  class="col-md-3">
				<button class="btn navbtn txtnav" onclick="searchDate()" style=" color: #ffffff !important;"><span class="glyphicon glyphicon-search"></span></button>
					<!--csv report-->
				 <a  id="csv" href="/reports/problemMangementCSV">

				    <img src="/images/CSV.png" style="width:40px"></img>
				</a>
			</div>
		
		</div>
 
	</div>
	
	<br><br><br>
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
  <script type="text/javascript" src="/js/reports/problemmangement.js"></script>
  <script type="text/javascript" src="/js/reports/lang.js"></script>
