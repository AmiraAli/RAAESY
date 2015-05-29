<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- <title>jQuery UI Autocomplete - Default functionality</title> -->

  
 
</head>
@extends('app')

@section('content')
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="js/minified/themes/default.min.css" type="text/css" media="all" />
<!-- <script type="text/javascript" src="js/minified/jquery.sceditor.bbcode.min.js"></script>
 --><link rel="stylesheet" href="js/minified/jquery.sceditor.min.css" type="text/css" media="all" />
  <script type="text/javascript" src="js/minified/jquery.sceditor.bbcode.min.js"></script>



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
	<!-- <div class="ui-widget">
	  <label for="tags">Tags: </label>
	  <input id="tags">
	</div>
	<div id='new-projects'> </div> -->
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>

	{!! Form::open(['action' => ['ArticlesController@autocomplete'], 'method' => 'GET']) !!}
    {!! Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Enter name'])!!}
    {!! Form::submit('Search', array('class' => 'button expand')) !!}
    {!! Form::close() !!}


	{!! Form::close() !!}

  <textarea class="bbcode" rows="4" style="width: 100%">puts 'foo'</textarea>
<script>
$(function() {
  $("textarea").sceditor({
    plugins: "bbcode",
    style: "minified/jquery.sceditor.default.min.css"
  });
});
</script>

@endsection
