@extends('app')
@section('content')
<link href="/css/sections/sectionIndex.css" rel="stylesheet">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<br>
<div class="container">
<div class="row newSect">

	<button class="btn navbtn txtnav newTicket hv" onclick="createSection()" >New Section</button>
</div>
	<br><br>
<div  id="con" class="col-md-12" >
		
	@foreach ($sections as $section)
	<table class="table table-hover formed" id="{{$section->id}},sec">	
     	<tr id="{{$section->id}},sectionstest" class="info">
	          <td  id="{{ $section->id }}"> 
	          	<a href="#" style="text-decoration:none;" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right  navtxt hideEdit{{$section->id}}" onclick="tog({{ $section->id }},'{{$section->name}}');">
	          	{{ $section->name }}</a>
	          	<input type="hidden" id="idSection" value="{{ $section->id }}"> 
	          </td>
	          <td class="text-center _{{$section->id}}">
	          	<a href="#" onclick="createCategory({{$section->id}},'{{$section->name}}')" id="_{{$section->id}}" class="btn navbtn txtnav btn disBut hv" >New Category</a>
	          </td>
			<td class="text-center {{$section->id}}error">
			&ensp; &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
			<div class="{{$section->id}}removeButton" style="display:inline;">
	            <button onclick="Edit({{$section->id}}+',sectionstest')" class=" btn btn-link do"><img src="/images/edit.png" width="30px" class="do" height="30px">	</button>
	          &ensp;&ensp; &ensp;
		          <a href="#" onclick="deleteSection( {{ $section->id }}+',sectionstest' )"><img src="/images/delete.png" width="30px" height="30px"></a>
		          </div>
	            </td>
     	 </tr>
	</table>

	<div class="container col-md-10 table_show" id="table_show{{$section->id}}" >
	<table id="{{$section->id}}categories" class="table table-hover form sec" >
		<?php $x = 0; ?>
	@foreach ($categories as $category)

	@if($category->section_id == $section->id)
		<?php $x = 1; ?>
     <tr class=" {{$section->id}}category" id="{{ $category->id }}category">  						        
        	<td class="col-md-5 {{$category->id}}hideEditCat">

        	<div class=" navtxt hideEditCat{{$category->id}}" >{{$category->name}}</div></td>
        	<td class=" col-md-5 {{$category->id}}errorcat"></td>
        	<td class="text-center ">
        	<div class="{{$category->id}}removeButtonCat" style="display:inline;">
        	<button class="btn btn-primary btn-xs disEditCat" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="EditCat({{ $category->id }}+'category','{{$category->id}}')" ><span class="glyphicon glyphicon-pencil disEditCat"></span></button>

	      &ensp;&ensp; &ensp;

	    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteCategory( {{ $category->id }}+'category','{{$section->id}}' )"><span class="glyphicon glyphicon-trash"></span></button>			            	
		  		</div>
		 	</td>			
        @endif
 	 </tr>
	@endforeach
	</table>
	<div id="e{{$section->id}}" class="err">
		<?php if($x == 0){ ?>
			<center>There is no categories in this section</center>
		<?php }?>

	</div>
	</div>

	@endforeach
		
	</div>
	
<!-- ___________________________________________________________________________________-->

@endsection

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/js/sections/toggle.js"></script>
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
		   $.ajax({
			    url: '/sections/'+ids,
			    type: 'DELETE',
			    success: function(result) {

				var x="text-center "+ids+"category";
				var allChild=document.getElementsByClassName(x);
				for(i=0;i<allChild.length;i++){

					allChild[i].innerHTML="";
				}
				 document.getElementById(ids+",sec").remove(); 
				 document.getElementById("table_show"+ids).remove();
				 				  
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}

function deleteCategory(id, section){ 
		   $.ajax({
			    url: '/categories/'+id,
			    type: 'DELETE',
			    success: function(result) {
					 $('#'+id).remove();

					 if ($('#'+section+"categories").has( "tr" ).length == 0) {

						 $("#e"+section).html("<center>There is no categories in this section</center>");
					}
						 

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}


	</script>
</body>
</html>
