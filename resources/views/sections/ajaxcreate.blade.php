<table class="table table-hover formed">	
	<tr id="{{$section->id}},sectionstest" class="info">
      <td  id="{{ $section->id }}"> 
      	<a href="#" style="text-decoration:none;" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right hideEdit{{$section->id}}" onclick="tog({{ $section->id }},'{{$section->name}}');">
      	{{ $section->name }}</a>
      	<input type="hidden" id="idSection" value="{{ $section->id }}"> 
      </td>
      <td class="text-center _{{$section->id}}">
      	<a href="#" onclick="createCategory({{$section->id}},'{{$section->name}}')" id="_{{$section->id}}" class="btn btn-primary btn disBut" >New Category</a>
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

    <table id="{{$section->id}}categories" class="table table-hover form sec" style="display:none">
    </table>

 <script type="text/javascript" src="/js/sections/editSection.js"></script>
  <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <script src="/js/sections/toggle.js"></script>
    

