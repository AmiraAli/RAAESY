
@extends('app')

@section('content')
	{!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'route' => array('articles.store'))) !!}
	<div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        {!! Form::text('body',null,['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
    	{!! Form::label('IS SHOW', 'IS SHOW:') !!}
    	{!! Form::checkbox('isshow', 'value', true) !!}
    <div class="form-group">
    <br/>
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
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>


	{!! Form::close() !!}

@endsection