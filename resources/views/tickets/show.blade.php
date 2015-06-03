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
<div class="container">

<!------------------------------------------ticketbody------------------------------------------------------------------------->
  <div class="leftposition">
	<div class="panel panel-default ticketbody">
	  <div class="panel-body " id="takeoverajax">
@if(Auth::user()->type=="admin" or Auth::user()->id==$ticket->user_id )
<input type="hidden" id="techid" value="tech,{{$ticket->tech_id}}">
		@if($ticket)
			@if($ticket->status=='open')
			   <button name="close" id="{{$ticket->id}}"  onclick="Status({{$ticket->id}})">closed</button>
			@endif
			@if($ticket->status=='close')
			   <button name="open" id="{{$ticket->id}}"  onclick="Status({{$ticket->id}})" >reopen</button>
			@endif
			@endif
@if(Auth::user()->type=="admin")
			@if(!$ticket->tech_id and $ticket->status=='open')
			   <button id="{{$ticket->id}},takeover" onclick="TakeOver({{$ticket->id}}+',takeover')">takeover</button>
			@endif
		@endif
@endif
		<div id='newelement'>

		</div>
		<h4>  {{ $ticket->subject->name }}</h4>
		<p>  {!! $ticket->description !!}</p>
	  </div>
	</div>


<!---------------------------------------commentbody--------------------------------------------------------------->
  <div id="comments">
	@foreach($comments as $comment)
	  <div class="panel panel-default  commentbody" id="{{$comment->id}}Comments">
	    <div class='panel-heading'>{{$comment->user->fname}} {{$comment->user->lname}}</div>
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
<!------------------------------------------AddComment------------------------------------------------------->
  <div>
     <form name="addForm" method = 'post'  class = 'form-horizontal' action="javascript:add({{$ticket->id}})">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
   </div>
</div>
<!---------------------------------------ticketdetails------------------------------------------------------------>
<div class="rightposition">
	<div class="panel panel-default ticketdetails">
	  <div class="panel-heading">
		<h3 class="panel-title">Ticket Details</h3>
	  </div>
	  <div class="panel-body assigned"> 
		<h4 class="title">Section    </h4>{{ $ticket->category->section->name }}<br>
		<h4 class="title">Category   </h4>{{ $ticket->category->name }}<br>
		<h4 class="title">Periorty   </h4>{{ $ticket->priority }}<br>
		<h4 class="title">StartDate  </h4>{{ $ticket->created_at }}<br>
		<h4 class="title">Due        </h4>{{ $ticket->deadline }}<br>
		<h4 class="title">From       </h4> {{ $ticket->user->fname }} {{$ticket->user->lname}}<br>
		<h4 class="title">AssignedTo </h4> @if($ticket->tech){{ $ticket->tech->fname}}  {{ $ticket->tech->lname}}@endif
	  </div>
	</div>
<!-----------------------------------relatedassets-------------------------------------------------------------------------------->
@if(Auth::user()->type=="admin")	
	<div class="panel panel-default relatedassets">
		  <div class="panel-heading">
			    <h3 class="panel-title">Related Assets</h3>
		  </div>
	          <div class="panel-body">
			@foreach($relatedAssets as $relatedAsset)
				<input type="hidden" id="{{$relatedAsset->id}}:showenassets" class="showenasset">
				<a href="/assets/{{$relatedAsset->id}}">{{$relatedAsset->name}}</a><br>
			@endforeach

			
<div id="addnewasset">
				<button id="{{$ticket->id}}:newasset" onclick="AddAssets({{$ticket->id}}+':newasset')">AddAsset</button>

			</div><div id="asseterrormessage"></div>

		  </div>
	</div>
<!------------------------------------------relatedtags--------------------------------------------------------------------------->

	<div class="panel panel-default relatedtags">
		<div class="panel-heading">
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
</div>
<!------------------------------------------------------------------------------------------------------------------->
</div>
@endsection

</body>
</html>
