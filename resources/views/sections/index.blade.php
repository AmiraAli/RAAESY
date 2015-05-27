@extends('app')
@section('content')
<div class="container">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

	<table class="table table-hover">
		<thead>
			<tr>
				<th class="text-center">Name</th>
			</tr>
		</thead>
		<tbody>
     		@foreach ($sections as $section)
			        <tr>
			            <td class="text-center">{{ $section->name }}</td>

			            <td class="text-center">
			            	<a href="/sections/{{$section->id}}" class="btn btn-success btn">Open</a>
			            </td>
			            <td class="text-center">
			            	 <a href="/sections/{{$section->id}}/edit " class="btn btn-warning btn" >Edit</a>
			            </td>
			            <td class="text-center">
			            	

				            <button class="btn btn-danger" onclick="deleteSection( {{ $section->id }} )">Delete</button>

			            </td>

			        </tr>
     		@endforeach

     	</tbody>
	</table>
</div>

@endsection

<script>

		window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

		function deleteSection(id){ 
			//ajax request
		   $.ajax({
			    url: '/sections/'+id,
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