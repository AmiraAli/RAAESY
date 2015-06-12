@extends('app')
@section('content')

<link href="/css/users/showUser.css" rel="stylesheet">

<div class="container">
	<div class="row ">
		<div class="col-md-5 my">
			<div class="panel">
				<div class="panel-heading navbtn txtnav fnt" >{{$user->fname}} {{$user->lname}}
				</div>

				<div class="panel-body">

				<div class="container">
		         	<label for="subject" class="col-sm-2 control-label clr">First Name</label>
		            <div class="col-sm-10 fnt">
		                {{$user->fname}}
		            </div>
		      
			        <br/>
			        <br/>
				        
					<label for="subject" class="col-sm-2 control-label clr">Last Name</label>
		            <div class="col-sm-10 fnt">
		                {{$user->lname}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label clr">Email</label>
		            <div class="col-sm-10 fnt">
		                {{$user->email}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label clr">Phone</label>
		            <div class="col-sm-10 fnt">
		                {{$user->phone}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label clr">Location</label>
		            <div class="col-sm-10 fnt">
		                {{$user->location}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	@if ($current_user->type == "admin")
						<label for="subject" class="col-sm-2 control-label clr">Role</label>
			            <div class="col-sm-10 fnt">
			                @if ($user->type == "admin")
			                	Admin
			                @elseif ($user->type == "tech")
			                	Technician
			                @else
			                	Regular User
			                @endif
			            </div>
			      
				        <br/>
				        <br/>

						<label for="subject" class="col-sm-2 control-label clr">Disabled</label>
			            <div class="col-sm-10 fnt">
			                @if ($user->isspam == true)
								<input type="checkbox" disabled="true" checked="true">
							@else
								<input type="checkbox" disabled="true" >
							@endif

			            </div>
		      		

			        	<br/>
			        	
			        @endif

			        <div class="butn col-sm-8"> <a  href="/users/{{$user->id}}/edit" class="btn btn-default">Edit</a></div>

				</div>
			</div>
		</div>
	</div>
</div>



@stop
