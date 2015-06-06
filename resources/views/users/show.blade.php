@extends('app')
@section('content')





<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{$user->fname}} {{$user->lname}}

					<div class="pull-right"> <a  href="/users/{{$user->id}}/edit">edit</a></div>

				</div>

				<div class="panel-body">

				<div class="container">
		         	<label for="subject" class="col-sm-2 control-label">First Name</label>
		            <div class="col-sm-10">
		                {{$user->fname}}
		            </div>
		      
			        <br/>
			        <br/>
				        
					<label for="subject" class="col-sm-2 control-label">Last Name</label>
		            <div class="col-sm-10">
		                {{$user->lname}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label">Email</label>
		            <div class="col-sm-10">
		                {{$user->email}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label">Phone</label>
		            <div class="col-sm-10">
		                {{$user->phone}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	<label for="subject" class="col-sm-2 control-label">Location</label>
		            <div class="col-sm-10">
		                {{$user->location}}
		            </div>
		      
			        <br/>
			        <br/>
				  
				  	@if ($current_user->type == "admin")
						<label for="subject" class="col-sm-2 control-label">Role</label>
			            <div class="col-sm-10">
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

						<label for="subject" class="col-sm-2 control-label">Disabled</label>
			            <div class="col-sm-10">
			                @if ($user->isspam == true)
								<input type="checkbox" disabled="true" checked="true">
							@else
								<input type="checkbox" disabled="true" >
							@endif

			            </div>
		      		

			        	<br/>
			        	<br/>
			        @endif

				</div>
			</div>
		</div>
	</div>
</div>



@stop
