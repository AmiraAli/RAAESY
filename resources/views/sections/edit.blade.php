<div class="cancelEdit">
  <div class="form-group col-md-6 " id="sec{{$section->id}}"  style="display:inline">
    <input type="text" class="form-control " id="exampleInputEmail1"  name="name" value="{{$section->name}}">
  </div>
 <div style="display:inline">
  <button type="submit" class="btn btn-primary" onclick="SaveEdit({{$section->id}}+',sectionstest','{{$section->name}}')"><span class="glyphicon glyphicon-ok"></span></button>

 &ensp; &ensp;

<button  onclick="cancelEditSec()" class="btn btn-danger "><span class="glyphicon glyphicon-remove"></span> </button>
<input type="hidden" id="idSect" value="{{ $section->id }}"> 

</div>
</div>
 <script type="text/javascript" src="/js/sections/editSection.js"></script>
  <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <script src="/js/sections/toggle.js"></script>
