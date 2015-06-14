<td  id="{{ $section->id }}"> 
  	<a href="#" style="text-decoration:none;" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right navtxt hideEdit{{$section->id}} navtxt" onclick="tog({{ $section->id }},'{{$section->name}}');">
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
				            
 <script type="text/javascript" src="/js/sections/editSection.js"></script>
  <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <script src="/js/sections/toggle.js"></script>
