<html>
<head>
	<link href="/css/ticketshow.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/js/ticket_status.js"></script>
	<script src="/js/comments.js"></script>
	<script src="/js/add_asset_ticket.js"></script>
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')
<br>
<div class="container">

<div class="col-md-8">
  <div class="row ">
  <div class="col-md-12 ">
<!-- ticketbody-->
  <div class="leftposition">
	<div class="panel ticketbody">
	  <div class="panel-body " id="takeoverajax">
@if(Auth::user()->type=="admin" or Auth::user()->id==$ticket->user_id )
<input type="hidden" id="techid" value="tech,{{$ticket->tech_id}}">
		@if($ticket)
			@if($ticket->status=='open')
			   <button name="close" id="{{$ticket->id}}"  onclick="Status({{$ticket->id}})">close</button>
			@endif
			@if($ticket->status=='close')
			   <button name="open" id="{{$ticket->id}}"  onclick="Status({{$ticket->id}})" >reopen</button>
			@endif
			@endif
@if(Auth::user()->type=="admin")
			@if(!$ticket->tech_id and $ticket->status=='open')
			   <button id="{{$ticket->id}},takeover" onclick="TakeOver({{$ticket->id}}+',takeover')">Assign To</button>
			@endif
		@endif
@endif
		<div id='newelement'>

		</div>
		<div class="row">
		<h4 class="col-md-6">  {{ $ticket->subject->name }}</h4> 
		@if($ticket->file)
			<div class="col-md-6">
			<h4>More details upladed:</h4>
			<p><a href="{{ URL::to( '/files/'. $ticket->file)  }}" target="_blank">{{ $ticket->file }}</a></p>
			</div>
		@endif
		</div>
		<div class="row">
		<p>  {!! $ticket->description !!}</p>
		</div>
	  </div>
	</div>


<!--commentbody-->
  <div id="comments">
	@foreach($comments as $comment)
	  <div class="panel commentbody" id="{{$comment->id}}Comments">
	    <div class='panel-heading navbtn txtnav'>{{$comment->user->fname}} {{$comment->user->lname}}</div>
	      <div class="panel-body ">

		@if($comment->readonly==1)
			@if(Auth::user()->id==$comment->user_id)
		 		<button name="{{$comment->id}}_{{$ticket->id}}" id="{{$comment->body}}"
					onclick='edit(this)' class="btn btn-primary buttonright">Edit</button>
			@endif
			@if(Auth::user()->type=="admin" or Auth::user()->id==$comment->user_id)
		 		<button name="{{$comment->id}}_{{$ticket->id}}" onclick='Delete(this)' class="btn btn-primary
				buttonright">Delete</button> 		
			@endif		
		@endif
	        {{$comment->body}}<br>
		@if($comment->created_at!=$comment->updated_at)
			{{$comment->updated_at}}
		@else
			{{$comment->created_at}}
		@endif
              </div>
	    
	  </div>

	@endforeach
  </div>
<!--AddComment-->
<input type="hidden" id="hidden" value="{{ csrf_token() }}" >
<div id="addcomments">
 @if($ticket->status=='open')
     <form name="addForm" method = 'post'  class = 'form-horizontal' action="javascript:add({{$ticket->id}})">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			<div class="form-group">
				<div class="col-md-6">
					<textarea type="text" class="form-control" name="body" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button    type="submit"  class="btn btn-primary">
						Add comment
					</button>
				</div>
			</div>
	</form>
@endif
   </div>

</div></div></div></div>

<div class="col-md-4 ">
  <div class="row ">
<div class="col-md-12 ">
<!--ticketdetails-->
<div class="rightposition">
	<div class="panel ticketdetails">
	  <div class="panel-heading navbtn txtnav">
		<h3 class="panel-title">Ticket Details</h3>
	  </div>
	  <div class="panel-body assigned"> 
		<span class="title">Section </span>{{ $ticket->category->section->name }}<br>
		<span class="title">Category </span>{{ $ticket->category->name }}<br>
		<span class="title">Periorty </span>{{ $ticket->priority }}<br>
		<span class="title">Start Date </span>{{ $ticket->created_at }}<br>
		<span class="title">Due   </span>{{ $ticket->deadline }}<br>
		<span class="title">From  </span> {{ $ticket->user->fname }} {{$ticket->user->lname}}<br>
		<span class="title">Assigned To  </span> @if($ticket->tech){{ $ticket->tech->fname}}  {{ $ticket->tech->lname}}@endif
	  </div>
	</div>
<!--relatedassets-->
@if(Auth::user()->type=="admin")	
	<div class="panel relatedassets">
		  <div class="panel-heading navbtn txtnav">
			    <div class="panel-title" style="display:inline;">Related Assets</div>
			    <div id="addnewasset">
				<button id="{{$ticket->id}}:newasset" onclick="AddAssets({{$ticket->id}}+':newasset')" class="butn">AddAsset</button>

			</div>
		  </div>
	          <div class="panel-body">
			@foreach($relatedAssets as $relatedAsset)
				<input type="hidden" id="{{$relatedAsset->id}}:showenassets" class="showenasset">
				<a href="/assets/{{$relatedAsset->id}}">{{$relatedAsset->name}}</a><br>
			@endforeach

			
<div id="asseterrormessage"></div>

		  </div>
	</div>
<!--relatedtags-->

	<div class="panel relatedtags">
		<div class="panel-heading navbtn txtnav">
			<h3 class="panel-title">Related tags</h3>
		</div>
		<div class="panel-body"> 


			@foreach($relatedTickets as $Ticket)
				@if($Ticket->ticket_id!=$ticket->id)
					<a href="/tickets/{{$Ticket->ticket_id}}">{{substr($Ticket->description,0,10)."....."}}</a><br>
				@endif
			@endforeach


		</div>
	</div>
@endif
</div></div></div></div>
<!---->
</div>
@endsection

</body>
</html>
