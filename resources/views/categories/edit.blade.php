
  <div class="form-group" id="yarab{{$category->id}}">
    <label for="exampleInputEmail2">Category Name</label>
    <input type="text" class="form-control" id="exampleInputEmail2"  name="name" value="{{$category->name}}">
  </div>

  <button  class="btn btn-primary" onclick="SaveCatEdit({{$category->id}}+'category','{{$category->id}}','{{$category->name}}')">Submit</button>


