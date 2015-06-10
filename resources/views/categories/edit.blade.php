<div class="cancelEditCat">
  <div class="form-group col-md-6" id="yarab{{$category->id}}" style="display:inline">
    <input type="text" class="form-control" id="exampleInputEmail2"  name="name" value="{{$category->name}}">
  </div>
 <div style="display:inline">
  <button type="submit" class="btn btn-primary" onclick="SaveCatEdit({{$category->id}}+'category','{{$category->id}}','{{$category->name}}')"><span class="glyphicon glyphicon-ok"></span></button>

 &ensp; &ensp;

<button  onclick="cancelEditCat()" class="btn btn-danger "><span class="glyphicon glyphicon-remove"></span> </button>  
<input type="hidden" id="idCat" value="{{ $category->id }}"> 

</div>
</div>

 <script type="text/javascript" src="/js/sections/editSection.js"></script>
  <script type="text/javascript" src="/js/sections/editCategories.js"></script>
  <script src="/js/sections/toggle.js"></script>



