
<td class="col-md-5 {{$category->id}}hideEditCat">

    	<div class=" hideEditCat{{$category->id}}" >{{$category->name}}</div></td>
    	<td class=" col-md-5 {{$category->id}}errorcat"></td>
    	<td class="text-center ">
    	<div class="{{$category->id}}removeButtonCat" style="display:inline;">
	<button class="btn btn-primary btn-xs disEditCat" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="EditCat({{ $category->id }}+'category','{{$category->id}}')" ><span class="glyphicon glyphicon-pencil disEditCat"></span></button>

  &ensp;&ensp; &ensp;

	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteCategory( {{ $category->id }}+'category' )"><span class="glyphicon glyphicon-trash"></span></button>			            	
  		</div>
 	</td>
 <script type="text/javascript" src="/js/sections/editSection.js"></script>
  <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <script src="/js/sections/toggle.js"></script>