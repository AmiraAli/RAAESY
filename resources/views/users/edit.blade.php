<head>
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>
<body>

@extends('app')

@section('content')
<div class="container-fluid">
<br>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel ">
				<div class="panel-heading navbtn txtnav">{{$user->fname}} {{$user->lname}}</div>
				<div class="panel-body">
				 @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
       			 @endif
{!! Form::open(['route'=>['users.update',$user->id],'method'=>'put'])!!}

<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fname" value="{{ $user->fname}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lname" value="{{$user->lname}}">
							</div>
						</div>




						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ $user->email }}">
							</div>
						</div>

						
						<div class="form-group">
							<label class="col-md-4 control-label">Phone</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{$user->phone}}">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location" value="{{$user->location}}">
							</div>
						</div>

						@if ($current_user->type == "admin"  && $user-> id != "1" )

							<div class="form-group">
	     						<label class="col-md-4 control-label">Role</label>
								<div class="col-md-6">
								        <select  name="type">
									        <option value="regular"
											@if($user->type ==="regular") {{"selected=true"}} @endif >Regular user</option>
									        <option value="tech"
									        @if($user->type ==="tech") {{"selected=true"}} @endif >Technician</option>
									        <option value="admin"
									        @if($user->type ==="admin") {{"selected=true"}} @endif >Admin</option>
									    </select>



							    </div>
						    </div>

							 <div class="form-group">
	     						<label class="col-md-4 control-label">Disable</label>
									<div class="col-md-6">
								        @if ($user->isspam == 0)
								            {!! Form::checkbox('isspam', 'value') !!}
								        @else
								            {!! Form::checkbox('isspam', 'value',true) !!}
								        @endif

	  						        </div>
						    </div>
					  
					  	@endif

					    @if($current_user->id == $id  ) 
					    <div class="form-group">
					    <div class="col-md-6 col-md-offset-4" >
					    	<a class="btn btn-link" href="/users/changepassword/{{$user->id}}">Change Password</a>
					    </div>
					    </div>
					    @endif


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn navbtn txtnav">
									Done Editing
								</button>
							</div>
						</div>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

</body>