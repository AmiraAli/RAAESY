@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Edit User</div>
				<div class="panel-body">
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
						<div class="form-group">
     						<label class="col-md-4 control-label">Type:</label>
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
     						<label class="col-md-4 control-label">Disable:</label>
							<div class="col-md-6">
								<input type="checkbox" name="isspan" 
								 @if($user->isspam ==="1") {{"checked=true"}} @endif>
					    </div>




						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
	</div>
</div>
@stop
