@extends('app')

@section('content')
<div class="container">
 {!! Form::open(['route'=>'tickets.store','method'=>'post']) !!}
	<div class="form-group">
		<label>Subject</label>
	    <select class="form-control" name="subject">
		    @foreach ($subjects as $subject)
		    	<option value="{{ $subject->id }}"> {{ $subject->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<textarea class="form-control" rows="3" name="description"></textarea>
	</div>
	<div class="form-group">
		<label>Category</label>
	    <select class="form-control" name="category">
	    @foreach ($sections as $section)
	    <optgroup label=" {{ $section->name }} " >
		    @foreach ($categories as $category)
		    	@if ($category->section_id === $section->id )
		    		<option value="{{ $category->id }}" > {{ $category->name }}</option>
		    	@endif
			@endforeach
		</optgroup>
		@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>Priority</label>
	    <select class="form-control" name="priority">
		    <option value="low">LOW</option>
		    <option value="high">High</option>
		    <option value="critical">Critical</option>
		</select>
	</div>
    <div class="form-group">
	    <label >Attach File</label>
	    <input type="file" name="file">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  {!! Form::close() !!}
</div>
@endsection

