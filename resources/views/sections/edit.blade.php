@extends('app')
@section('content')
<script src="/js/DeleteUser.js"></script>
 	<script src="/js/users/index.js"></script>
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="/js/users/toggleSearch.js"></script>
<div class="container">
{!! Form::open(['route' => ['sections.update' , $section->id] ,'method' => 'put']) !!}
  <div class="form-group">
    <label for="exampleInputEmail1">Section Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{$section->name}}">
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>

{!! Form::close() !!}
</div>
@endsection