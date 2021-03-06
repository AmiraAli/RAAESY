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
     		@foreach ($categories as $category)
			        <tr id="{{$category->id}}category">
			            <td class="text-center">{{ $category->name }}</td>


			            <td class="text-center">
			            	 <a href="/categories/{{$category->id}}/edit " class="btn btn-warning btn" >Edit</a>
			            </td>
			            <td class="text-center">
			            	

				            <button class="btn btn-danger" onclick="deleteCategory( {{ $category->id }}+'category' )">Delete</button>

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

		function deleteCategory(id){ 
		console.log(id);
		   $.ajax({
			    url: '/categories/'+id,
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
