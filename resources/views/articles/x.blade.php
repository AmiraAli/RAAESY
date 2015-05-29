<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- <title>jQuery UI Autocomplete - Default functionality</title> -->

  
 
</head>
@extends('app')

@section('content')
 <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>
  
 <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
   
	{!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'route' => array('articles.store'))) !!}
	<div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        <!-- {!! Form::text('body',null,['class'=>'form-control']) !!} -->
        <!-- {!! Editor::view() !!} -->
        {!! Editor::view('body', 'hhh', ['class' => 'form-control']) !!}
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
  <br/>


    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>


@endsection
