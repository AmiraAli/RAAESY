@extends('app')

@section('content')
<div class="container">
 {!! Form::open(['route'=>['tickets.update',$ticket->id],'method'=>'put']) !!}
	<div class="form-group">
		<label>Subject</label>
	    <select class="form-control" name="subject">
		    @foreach ($subjects as $subject)
		      @if($ticket->subject_id === $subject->id)
		    	<option value="{{ $subject->id }}" selected="true"> {{ $subject->name }}</option>
			  @else
			    <option value="{{ $subject->id }}"> {{ $subject->name }}</option>	
			  @endif		
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<textarea class="form-control" rows="3" name="description">{{ $ticket->description }}</textarea>
	</div>
	<div class="form-group">
		<label>Category</label>
	    <select class="form-control" name="category">
	    @foreach ($sections as $section)
	    <optgroup label=" {{ $section->name }} " >
		    @foreach ($categories as $category)
		    	@if ($category->section_id === $section->id )
		    		  @if($ticket->scategory_id === $category->id)
				    	<option value="{{ $category->id }} " selected="true"> {{ $category->name }}</option>
					  @else
					    <option value="{{ $category->id }}"> {{ $category->name }}</option>	
					  @endif
		    	@endif
			@endforeach
		</optgroup>
		@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>Priority</label>
	    <select class="form-control" name="priority">
	    	@if ($ticket->priority === "low" )
		      <option value="low" selected="true">LOW</option>
		    @else
		    	<option value="low" >LOW</option>
		    @endif
		    @if ($ticket->priority === "high" )
		      <option value="high" selected="true">High</option>
		    @else
		    	<option value="high">High</option>
		    @endif
		    @if ($ticket->priority === "critical" )
		      <option value="critical" selected="true">Critical</option>
		    @else
		      <option value="critical">Critical</option>
		    @endif
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

