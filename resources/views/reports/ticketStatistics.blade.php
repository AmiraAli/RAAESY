@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container" id="container">
	<div class="raw">
		<div class="col-md-5"  id="customedate">
			{{trans('problemmangement.from')}}:<input type="date" id="startdate">
			{{trans('problemmangement.to')}}:<input type="date" id="enddate">
		</div>
@if (Session::get('lang') =="ar")
	<a  href="/reports/problemMangement?lang=en" class="btn navbtn txtnav" >English</a>
@else
	<a  href="/reports/problemMangement?lang=ar" class="btn navbtn txtnav" >عربى</a>
@endif
		<div style="float:left;">
			<button class="btn btn-primary" onclick="searchDate()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
	 <!--csv report-->
 <a id="csv" href="/reports/problemMangementCSV">

    <img src="/images/CSV.png" style="width:40px"></img>

</a>
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

 	
</div>
@endsection
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script type="text/javascript" src="/js/reports/problemmangement.js"></script>
 <script type="text/javascript" src="/js/reports/lang.js"></script>
