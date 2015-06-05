<html>
<head>
<style>
.formed
{
    width:90%;
    table-layout:fixed;
    padding:0;
    margin:0;
}
.form{
    width:90%;
    table-layout:fixed;
    padding:0;
    margin:0;
}
</style>
</head>
<body>
@extends('app')
@section('content')
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div class="container">
<div class="row">
	<button class="btn btn-primary" onclick="createSection()" >Create New Section</button>
</div>

	
<div  id="con" class="col-md-12 " >
		
			

	     		@foreach ($sections as $section)
	<table class="table table-hover formed">	

				     <tr id="{{$section->id}},sectionstest">
				          <td class="text-center" id="{{ $section->id }}"> 
				          	<a href="#" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right" onclick="tog({{ $section->id }},'{{$section->name}}');">
				          	</a>{{ $section->name }}<input type="hidden" id="idSection" value="{{ $section->id }}"> 
				          </td>
				          <td class="text-center">
				          	<a href="#" onclick="createCategory({{$section->id}},'{{$section->name}}')" class="btn btn-primary btn" >New Category</a>
				          </td>
						<td class="text-center">
				            <a href="#" onclick="Edit({{$section->id}}+',sectionstest')" class="btn btn-warning btn" >Edit</a>
				            </td>
				            <td class="text-center">
					          <button class="btn btn-danger" onclick="deleteSection( {{ $section->id }}+',sectionstest' )">Delete</button>
				            </td>
				      </tr>
</table>

				      <table id="{{$section->id}}categories" class="table table-hover form" >
							@foreach ($categories as $category)

							     <tr class="text-center {{$section->id}}category" id="{{ $category->id }}category">  
							        		
							        @if($category->section_id == $section->id)

							        	<td>{{$category->name}}</td>
							        	<td class="text-center">
								       	 	<a href="#" onclick="EditCat({{ $category->id }}+'category','{{$category->id}}')" class="btn btn-warning btn" >Edit</a>
								    	</td>
								    	<td class="text-center">			            	
									  		<button class="btn btn-danger" onclick="deleteCategory( {{ $category->id }}+'category' )">Delete</button>
									 	</td>			
							        @endif
							 	 </tr>
							@endforeach
					</table>

	     	@endforeach

		
	</div>
	<!-- _____________________________________________________________________ -->

	<div class="col-md-4" id="createSectionDiv">
		<div class="panel panel-success">

			<div class="panel-heading">New Section</div>

				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-6 control-label">Section Name</label>
						<div class="col-md-6">
	    					<input type="text" class="form-control" id="secName" placeholder="Section Name" name="name">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" onclick="saveSection()" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- ___________________________________________________________________________________-->

		<div class="col-md-4" id="createCategoryDiv">
			<div class="panel panel-success">

			<div class="panel-heading">New Category</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-6 control-label">Category Name</label>
						<div class="col-md-6">
	    					<input type="text" class="form-control" id="catName" placeholder="Category Name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-6 control-label">Section Name</label>
						<div class="col-md-6">
	    					<input type="text" class="form-control" id="cat_secName"  disabled="true">
	    					<input type="hidden" class="form-control" id="cat_secId"  disabled="true">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" onclick="saveCategory()" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
			</div>
		
		</div>
<!-- ___________________________________________________________________________________-->

@endsection

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/js/sections/toggle.js"></script>
	<script type="text/javascript" src="/js/sections/editSection.js"></script>
    <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <!-- <script type="text/javascript" src="/js/sections/newcategory.js"></script> -->
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
</body>
</html>
