@extends('app')

@section('content')

	<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

	<table class="table table-hover">
		<thead>
			<tr>
				<th class="text-center">Model</th>
				<th class="text-center">Manufacturer</th>
				<th class="text-center">Type</th>
				<th class="text-center">Serial Number</th>
				<th class="text-center">Belongs To</th>
				<th class="text-center">Location</th>
			</tr>
		</thead>
		<tbody>
     		@foreach ($assets as $asset)
			        <tr id="{{ $asset->id }}">
			            <td class="text-center">{{ $asset->name }}</td>
			            <td class="text-center">{{ $asset->manufacturer }}</td>
			            <td class="text-center">{{ $asset->assettype->name }}</td>
			            <td class="text-center">{{ $asset->serialno }}</td>
			            <td class="text-center">{{ $asset->user->fname }} {{ $asset->user->lname }}</td>
			            <td class="text-center">{{ $asset->location }}</td>
			            <td class="text-center">
			            	<a href="/assets/{{$asset->id}}" class="btn btn-success btn">Open</a>
			            </td>
			            <td class="text-center">
			            	 <a href="/assets/{{$asset->id}}/edit " class="btn btn-warning btn" >Edit</a>
			            </td>
			            <td class="text-center">
			            	<!-- {!! Form::open(['method' => 'Delete', 'route'=>['assets.destroy', $asset->id]]) !!}
				            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
				            {!! Form::close() !!} -->

				            <button class="btn btn-danger" onclick="deleteAsset( {{ $asset->id }} )">Delete</button>

			            </td>

			        </tr>
     		@endforeach

     	</tbody>
	</table>
	<script>

		window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

		function deleteAsset(id){ 
			//ajax request
		   $.ajax({
			    url: '/assets/'+id,
			    type: 'DELETE',
			    success: function(result) {
					 $('#'+id).remove();    
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}

	</script>
@endsection
