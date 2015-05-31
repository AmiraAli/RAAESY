@extends('app')

@section('content')

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

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

					{!! Form::open(['route' => 'assets.store', 'method' => 'post', 'class' => "form-horizontal"]) !!}						
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Model Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Manufacturer</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="manufacturer" value="{{ old('manufacturer') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								<select class="form-control" name="assettype_id" id="types">
									@foreach ($types as $type)
									    <option value="{{ $type->id }}" <?php if(old('assettype_id') === $type->id){ echo "selected"; } ?>>{{ $type->name }}</option>
									@endforeach
								</select>
								
								<div class="new-type">
									<a href="#" onclick="addType()">Add new type</a>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Serial Number</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="serialno" value="{{ old('serialno') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Belongs To</label>
							<div class="col-md-6">
								<select class="form-control" name="user_id">
									@foreach ($users as $user)

									    <option value="{{ $user->id }}" <?php if(old('user_id') === $user->id){ echo "selected"; } ?>>{{ $user->fname }} {{ $user->lname }}</option>
									@endforeach
								</select>
								<a href="/users/create" >Add new user</a>
								
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location" value="{{ old('location') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Comment</label>
							<div class="col-md-6">
								<textarea class="form-control" rows="3" name="comment" value="{{ old('comment') }}"></textarea>
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Add
								</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	window.onload = function() {
	    $.ajaxSetup({
            headers: {
                'X-XSRF-Token': $('meta[name="_token"]').attr('content')
            }
		});
	};
	
	function addType(){

		$(".new-type").html('<br><div class="form-group"><label class="col-md-4 control-label">New Type</label><div class="col-md-6"><input type="text" id="type-name" class="form-control" name="name"></div></div><div class="error" id="type-error"></div><div class="form-group"><div class="col-md-6 col-md-offset-4"><a href="#" class="btn btn-primary btn" onclick="saveType()">Add</a>&nbsp<a href="#" class="btn btn-primary btn" onclick="cancel()">Cancel</a></div></div>');
	}

	function saveType(){
		if ($("#type-name").val() != ""){
			$.ajax({
				dataType: "json",
			    url: '/assets/addType',
			    type: "post",
			    data: {'name' : $("#type-name").val()},
			    success: function(result) {
			    	// alert(result);
			    	$(".new-type").html('<a href="#" onclick="addType()">Add new type</a>');
			    	$('#types')
			         .append($("<option></option>")
			         .attr("value",result["id"])
			         .text(result["name"])); 
					console.log(result["name"]);
					$("#types").val(result["id"]);
			    	
				},
				error: function(jqXHR, textStatus, errorThrown) {
	                $("#type-error").html("<div class='alert alert-danger' role='alert'>this type is already exists</div>");
			    }
			})

		}
		else{
			$("#type-error").html("<div class='alert alert-danger' role='alert'>please enter the type name</div>");
		}
	}

	function cancel(){
    	$(".new-type").html('<a href="#" onclick="addType()">Add new type</a>');
	}
</script>

@endsection
