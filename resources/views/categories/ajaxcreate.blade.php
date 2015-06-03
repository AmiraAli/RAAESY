<tr class="text-center {{$category->section_id}}category" id="{{ $category->id }}category">  
					       
	<td>{{$category->name}}</td>
	<td class="text-center">
		<a href="#" onclick="EditCat({{ $category->id }}+'category','{{$category->id}}')" class="btn btn-warning btn" >Edit</a>
	</td>
	<td class="text-center">			            	
		<button class="btn btn-danger" onclick="deleteCategory( {{ $category->id }}+'category' )">Delete</button>
	</td>			        		
</tr>
							 	
