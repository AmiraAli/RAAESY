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
			   <button name="close" id="{{$ticket->id}}" class="btn btn-default" onclick="Status({{$ticket->id}})">close</button>
			@endif
			@if($ticket->status=='close')
			   <button name="open" id="{{$ticket->id}}" class="btn btn-default" onclick="Status({{$ticket->id}})" >reopen</button>
			@endif
			@endif
@if(Auth::user()->type=="admin")
			@if(!$ticket->tech_id and $ticket->status=='open')
			   <button id="{{$ticket->id}},takeover" onclick="TakeOver({{$ticket->id}}+',takeover')" class="btn btn-default">Assign To</button>
			@endif
		@endif
@endif
		<div id='newelement'>

		</div>
		<div class="row">
		<h4 class="col-md-6">  {{ $ticket->subject->name }}</h4> 
		<p>  {!! $ticket->description !!}</p>
		</div>
		<div class="row">
		

		@if($ticket->file)
			<div class="col-md-6">
			<span>More details uploded:</span>
			<a href="{{ URL::to( '/files/'. $ticket->file)  }}" target="_blank">{{ $ticket->file }}</a>
			</div>
		@endif
		</div>
	  </div>
	</div>

<div class="row">
<div class="col-md-11">
<!--commentbody-->
  <div id="comments">
	@foreach($comments as $comment)
	  <div class="panel commentbody" id="{{$comment->id}}Comments">
	    <div class='panel-heading navbtn txtnav'>{{$comment->user->fname}} {{$comment->user->lname}}</div>
	      <div class="panel-body {{$comment->id}}apendbtns">

		@if($comment->readonly==1)
			@if(Auth::user()->type=="admin" or Auth::user()->id==$comment->user_id)
		 		<button name="{{$comment->id}}_{{$ticket->id}}_dl" onclick='Delete(this)' class="btn btn-link
				buttonright"><span class='glyphicon glyphicon-remove' style='color:#d82727;'></span></button> 		
			@endif
			@if(Auth::user()->id==$comment->user_id)
		 		<button name="{{$comment->id}}_{{$ticket->id}}" id="{{$comment->body}}"
					onclick='edit(this)' class="btn btn-link buttonright cmtbtn"><span class='glyphicon glyphicon-pencil'></span></button>
			@endif		
		@endif
		<div id="{{$comment->id}}combdy">
		<div id="{{$comment->id}}combdy2">
	        {{$comment->body}}<br>
		@if($comment->created_at!=$comment->updated_at)
			{{$comment->updated_at}}
		@else
			{{$comment->created_at}}
		@endif
		</div>
              </div></div>
	    
	  </div>

	@endforeach
  </div></div></div>
<!--AddComment-->
<input type="hidden" id="hidden" value="{{ csrf_token() }}" >
<div id="addcomments">
 @if($ticket->status=='open')
     <form name="addForm" method = 'post'  class = 'form-horizontal' action="javascript:add({{$ticket->id}})">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			<div class="form-group col-md-9" >
				<div class="col-md-12">
					<textarea type="text" class="form-control" placeholder="Write Your Comment" name="body" rows="3" ></textarea>
				</div>
			</div>
			<div class="form-group col-md-1">
				<div class="col-md-12" style="margin-top:15px;">
					<button    type="submit"  class="btn btn-default">
						Comment
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
			    
		  </div> 
	          <div class="panel-body">
	          <div id="addnewasset">
				<button id="{{$ticket->id}}:newasset" onclick="AddAssets({{$ticket->id}}+':newasset')" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>  AddAsset</button>

			</div>
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
			<h3 class="panel-title">Related Tickets By tags</h3>
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