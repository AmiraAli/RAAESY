@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">New Asset</div>
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

					{!! Form::open(['route' => ['assets.update', $asset->id], 'method' => 'put', 'class' => "form-horizontal"]) !!}						
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Model Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ $asset->name }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Manufacturer</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="manufacturer" value="{{ $asset->manufacturer }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								<select class="form-control" name="assettype_id">
									@foreach ($types as $type)
									    <option value="{{ $type->id }}" <?php if ($asset->assettype_id == $type->id){ echo "selected"; } ?> >{{ $type->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Serial Number</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="serialno" value="{{ $asset->serialno }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Belongs To</label>
							<div class="col-md-6">
								<select class="form-control" name="user_id">
									@foreach ($users as $user)
									    <option value="{{ $user->id }}" <?php if ($asset->user_id == $user->id){ echo "selected"; } ?>>{{ $user->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location" value="{{ $asset->location }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Comment</label>
							<div class="col-md-6">
								<textarea class="form-control" rows="3" name="comment">{{ $asset->comment }}</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Save
								</button>
								
								<a href="/assets/ " class="btn btn-primary btn" >Cancel</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
