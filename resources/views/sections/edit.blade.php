
  <div class="form-group">
    <label for="exampleInputEmail1">Section Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{$section->name}}">
  </div>
 
  <button type="submit" class="btn btn-primary" onclick="SaveEdit({{$section->id}})">Save</button>



