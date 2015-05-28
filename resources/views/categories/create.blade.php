@extends('app')
@section('content')
<div class="container">
{!! Form::open(['route' => 'categories.store' , 'method' => 'post']) !!}
  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Category Name" name="name">
  </div>

  <select class="form-control" name="section_id">
  @foreach ($sections as $section)
  <option value="{{$section->id}}"> {{ $section->name }}</option>
@endforeach
</select>
 
  <button type="submit" class="btn btn-primary">Submit</button>

{!! Form::close() !!}
</div>
@endsection