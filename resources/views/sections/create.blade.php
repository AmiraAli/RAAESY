@extends('app')
@section('content')
<div class="container">

{!! Form::open(['route' => 'sections.store' , 'method' => 'post']) !!}
  <div class="form-group">
    <label for="exampleInputEmail1">Section Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Section Name" name="name">
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>

{!! Form::close() !!}
</div>
@endsection