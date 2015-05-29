@extends('app')
@section('content')



<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">

  
	{!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'route' => array('articles.store'))) !!}
	<div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        {!! Form::textarea('body',null,['class'=>'jqte-test']) !!}
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


    <script>
         $('.jqte-test').jqte();
    </script>


@endsection
