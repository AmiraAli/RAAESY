@extends('app')

@section('content')

<link href="/css/assets/show.css" rel="stylesheet">

<div class="container">
	<br><br>
	<div class="col-md-8">
	  	<div class="row ">
	    	<div class="col-md-9">
	      		<div class="panel">
	        		<div class="panel-heading navbtn txtnav fnt" >{{ $asset->name }}</div>
		        	<div class="panel-body">
		        		<div class="container">
				         	<label for="subject" class="col-sm-2 control-label clr">Model</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->name }}
				            </div>
				      
					        <br/>
					        <br/>
						        
							<label for="subject" class="col-sm-2 control-label clr">Manufacturer</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->manufacturer }}
				            </div>
				      
					        <br/>
					        <br/>
						  
						  	<label for="subject" class="col-sm-2 control-label clr">Type</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->assettype->name }}
				            </div>
				      
					        <br/>
					        <br/>
						  
						  	<label for="subject" class="col-sm-2 control-label clr">Serial Number</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->serialno }}
				            </div>
				      
					        <br/>
					        <br/>
						  
						  	<label for="subject" class="col-sm-2 control-label clr">Belongs To</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->user->fname }} {{ $asset->user->lname }}
				            </div>
				      
					        <br/>
					        <br/>

					        <label for="subject" class="col-sm-2 control-label clr">Location</label>
				            <div class="col-sm-10 fnt">
				                {{ $asset->location }}
				            </div>
				      
					        <br/>
					        <br/>

					        <div class="butn col-sm-8"> <a  href="/assets/{{$asset->id}}/edit" class="btn btn-default">Edit</a></div>

						</div>
		        	</div>
		        </div>
	        </div>
	    </div>
    </div>

    <div class="col-md-4">
	  	<div class="row ">
	    	<div class="col-md-12">
	      		<div class="panel">
	        		<div class="panel-heading navbtn txtnav fnt" >Related Tickets</div>
		        	<div class="panel-body">
		        		@foreach ($asset->tickets as $ticket)
							<div class="col-md-11 ticket" >		
								<div class="panel panel-info">
							  		<div class="panel-body"  id="tickets">	
							  			<a href="/tickets/{{$ticket->id}}"><strong>{{ $ticket->subject->name }}</strong></a><br>		    			
								    	@if (strlen($ticket->description) <= 100)
								    		{!! $ticket->description !!}
								    	@else
								    		{!! substr(strip_tags($ticket->description),0,50)." <b>.......</b>" !!}
								    	@endif
								 	</div>			
							    </div>
							</div>    
						@endforeach
		        	</div>
		        </div>
	        </div>
	    </div>
    </div>

</div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

@endsection
