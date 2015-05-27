@extends('app')
@section('content')
<div class="container">
{!! Form::open(['route' => ['categories.update' , $category->id] ,'method' => 'put']) !!}
  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{$category->name}}">
  </div>

    <select class="form-control" name="section_id">
  @foreach ($sections as $section)
  <option value="{{$section->id}}" <?php if ( $section->id == $category->section_id) echo 'selected' ;?> > {{ $section->name }}</option>
@endforeach
</select>
 
  <button type="submit" class="btn btn-primary">Submit</button>

{!! Form::close() !!}
</div>
@endsection