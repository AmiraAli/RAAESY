@if (Auth::check())

   
@extends('app')

@section('content')
<!-- <div class="container">
<form>
  <div class="form-group">
    <label>Subject</label>
    <input class="form-control"  placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <textarea class="form-control" rows="3"></textarea>
  <button type="submit" class="btn btn-default">Submit</button>



</form>
</div> -->
<!-- 

@foreach ($categories as $category)
    <p>This is category {{ $category->id }}</p>
@endforeach -->



@endsection


@endif
