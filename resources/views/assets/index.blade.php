@extends('app')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/deleteAsset.js"></script>
<script type="text/javascript" src="/js/searchAsset.js"></script>
<link href="/css/assets/index.css" rel="stylesheet">

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<div class="container">

	<div class="row" id="new-asset">
		<a  href="{{ url('/assets/csvimport') }}"><img src="/images/CSV.png" style="width:40px"></a>
		<a class="btn navbtn txtnav" href="{{ url('/assets/create') }}"> New Asset</a>
	</div>
	<div class="col-md-12">
		<div class="col-md-3">
			<div class="row">
				<div class="panel ">
					<div class="panel-heading navbtn txtnav">
						<h3 class="panel-title">Search</h3>
					</div>
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
								<label class="col-md-4 control-label navtxt">Model</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="name" id="model_name">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label navtxt">Manufacturer</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="manufacturer" id="manufacturer">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label navtxt">Type</label>
								<div class="col-md-7">
									<select class="form-control" name="assettype_id" id="type">
									<option value="">Select Type</option>
										@foreach ($types as $type)
										    <option value="{{ $type->id }}">{{ $type->name }}</option>
										@endforeach
									</select>
								
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label navtxt">Serial No</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="serialno" id="serialno">
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-4 control-label navtxt">Location</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="location" id="location">
								</div>
							</div>

							
							<div class=" row form-group">
								<div class="col-md-4 col-md-offset-4">
									<button type="submit" onclick="searchAsset()" class="btn navbtn txtnav">
										Search
									</button>
								</div>
								<div class="col-md-4">
									<button type="reset" class="btn navbtn txtnav">
										Reset
									</button>
								</div>
							</div>
						
						</form>
					</div>	
				</div>
			</div>
		</div>

		<div id="search_result" class="col-md-8">
			<table class="table table-hover">
				<thead>
					<tr class="navbtn txtnav">
						<th class="text-center">Model</th>
						<th class="text-center">Manufacturer</th>
						<th class="text-center">Type</th>
						<th class="text-center">Serial Number</th>
						<th class="text-center">Belongs To</th>
						<th class="text-center">Location</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
		     		@foreach ($assets as $asset)
				        <tr id="{{ $asset->id }}">
				            <td class="text-center"><a href="/assets/{{ $asset->id }}"><b>{{ $asset->name }}</b></a></td>
				            <td class="text-center">{{ $asset->manufacturer }}</td>
				            <td class="text-center">{{ $asset->assettype->name }}</td>
				            <td class="text-center">{{ $asset->serialno }}</td>
				            <td class="text-center"><a href="/users/{{ $asset->user_id}}"><b>{{ $asset->user->fname }} {{ $asset->user->lname }}</b></a></td>
				            <td class="text-center">{{ $asset->location }}</td>
				            <td class="text-center">
				            	<a href="/assets/{{$asset->id}}/edit" class="do"><img src="/images/edit.png" width="30px" height="30px">	</a>
				          		&ensp;&ensp; &ensp;
					          	<a href="#" onclick="deleteAsset( {{ $asset->id }} )"><img src="/images/delete.png" width="30px" height="30px"></a>

				            </td>
				        </tr>
		     		@endforeach
		     	</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
