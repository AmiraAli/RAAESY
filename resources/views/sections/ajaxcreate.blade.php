<tr id="{{$section->id}},sectionstest">
				          <td class="text-center" id="{{ $section->id }}"> 
				          	<a href="#" id="{{ $section->name }}" class="glyphicon glyphicon-triangle-right" onclick="tog({{ $section->id }},'{{$section->name}}');">
				          	</a>{{ $section->name }}<input type="hidden" id="idSection" value="{{ $section->id }}"> 
				          </td>
						<td class="text-center">
				            <a href="#" onclick="Edit({{$section->id}}+',sectionstest')" class="btn btn-warning btn" >Edit</a>
				            </td>
				            <td class="text-center">
					          <button class="btn btn-danger" onclick="deleteSection( {{ $section->id }}+',sectionstest' )">Delete</button>
				            </td>
				      </tr>
				      