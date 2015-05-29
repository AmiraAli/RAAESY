<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- <title>jQuery UI Autocomplete - Default functionality</title> -->

  
 
</head>
@extends('app')

@section('content')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<script src="/js/autocompleteTagArticle.js" type="text/javascript"></script>

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


@endsection
