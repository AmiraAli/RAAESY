@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading">Search</div>
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

					
					<form class= "form-horizontal" onsubmit="return false">					
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Model Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="model_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Manufacturer</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="manufacturer" id="manufacturer">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								<select class="form-control" name="assettype_id" id="type">
								<option value="">Select Type</option>
									@foreach ($types as $type)
									    <option value="{{ $type->id }}">{{ $type->name }}</option>
									@endforeach
								</select>
							
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Serial Number</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="serialno" id="serialno">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Location</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="location" id="location">
							</div>
						</div>

						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" onclick="searchAsset()" class="btn btn-primary">
									Search
								</button>
							</div>
						</div>
					
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="search_result"></div>

	<script>

		window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

		function searchAsset(id){

        	var formData = {
            'name'  : $('#model_name').val(),
            'type': $('#type').val(),
            'manufacturer' : $('#manufacturer').val(),
            'serialno' : $('#serialno').val(),
            'location' : $('#location').val()

        }; 

		   $.ajax({
			    url: '/assets/searchAssets',
			    type: 'post',
			    data: formData,
			    success: function(result) {
					 $('#search_result').html(result);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}

	</script>

@endsection