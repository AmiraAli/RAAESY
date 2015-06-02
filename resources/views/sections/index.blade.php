@extends('app')
@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/js/sections/toggle.js"></script>
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

			        <tr id="{{$section->id}},sectionstest">
			            <td class="text-center" id="{{ $section->id }}"> <a href="#" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right" onclick="tog({{ $section->id }},'{{$section->name}}');"></a>{{ $section->name }}<input type="hidden" id="idSection" value="{{ $section->id }}"> </td>
 						

<td class="text-center">
			            	 <a href="#" onclick="Edit({{$section->id}}+',sectionstest')" class="btn btn-warning btn" >Edit</a>
			            </td>
			            <td class="text-center">
			            	

				            <button class="btn btn-danger" onclick="deleteSection( {{ $section->id }}+',sectionstest' )">Delete</button>

			            </td>


			        </tr>
@foreach ($categories as $category)
			        <tr class="text-center {{$section->id}}category" id="{{ $category->id }}category">  
			        		
			        			@if($category->section_id == $section->id){
			        					<td>{{$category->name}}</td>
			        			}
			        			@endif



<td class="text-center">
			            	 <a href="#" onclick="EditCat({{ $category->id }}+'category','{{$category->id}}')" class="btn btn-warning btn" >Edit</a>
			            </td>
			            <td class="text-center">
			            	

				            <button class="btn btn-danger" onclick="deleteCategory( {{ $category->id }}+'category' )">Delete</button>

			            </td>


			        		
			          </tr>
@endforeach
     		@endforeach

     	</tbody>
	</table>
</div>

@endsection
 <script type="text/javascript" src="/js/sections/editSection.js"></script>
 <script type="text/javascript" src="/js/sections/editCategories.js"></script>
<script>

		window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

		function deleteSection(id){ 
			   var ids = id.split(',')[0];
			console.log(id);
		   $.ajax({
			    url: '/sections/'+ids,
			    type: 'DELETE',
			    success: function(result) {

				var x="text-center "+ids+"category";
				var allChild=document.getElementsByClassName(x);
				console.log(allChild);
				for(i=0;i<allChild.length;i++){

					allChild[i].innerHTML="";
				}
					
				 document.getElementById(id).remove(); 


 

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}



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


