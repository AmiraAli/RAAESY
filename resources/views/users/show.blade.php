@extends('app')
@section('content')
<link href="/css/users/showUser.css" rel="stylesheet">


<div class="container">
	<div class="row ">
		<div class=" my">
			<div class="panel">
				<div class="panel-heading navbtn txtnav fnt" >{{$user->fname}} {{$user->lname}}
				</div>

				<div class="panel-body">


		         	<label for="subject" class="col-sm-6 col-md-4 control-label clr">First Name</label>

		                {{$user->fname}}
		           
		      
			        <br/>
			        <br/>
				        
					<label for="subject" class="col-sm-6 col-md-4 control-label clr">Last Name</label>
		            
		                {{$user->lname}}
		           
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-6 col-md-4 control-label clr">Email</label>
		            
		                {{$user->email}}
		           
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-6 col-md-4 control-label clr">Phone</label>
		           
		                {{$user->phone}}
		            
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-6 col-md-4 control-label clr">Location</label>
		          
		                {{$user->location}}
		            
		      
			        <br/>
			        <br/>
				  
				  	@if ($current_user->type == "admin")
						<label for="subject" class="col-sm-6 col-md-4 control-label clr">Role</label>
			           
			                @if ($user->type == "admin")
			                	Admin
			                @elseif ($user->type == "tech")
			                	Technician
			                @else
			                	Regular User
			                @endif
			           
			      
				        <br/>
				        <br/>

						<label for="subject" class="col-sm-6 col-md-4 control-label clr">Disabled</label>
			           
			                @if ($user->isspam == true)
								<input type="checkbox" disabled="true" checked="true">
							@else
								<input type="checkbox" disabled="true" >
							@endif

			            
		      		

			        	<br/>
			        	
			        @endif

			         <a  href="/users/{{$user->id}}/edit" class="btn btn-default" style="float:right;">Edit</a>

				
			</div>
		</div>	
	</div>
</div>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


@stop
