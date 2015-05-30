@extends('app')
@section('content')



<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">

 <div class="container"> 
	{!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'route' => array('articles.store'))) !!}
	
     @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
       @endif

   <br/>

    <div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}

        {!! Form::text('subject',old('subject'),['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        {!! Form::textarea('body',old('body'),['class'=>'jqte-test']) !!}
    </div>
    <br/>


    <div class="form-group">
    	{!! Form::label('IS SHOW', 'IS SHOW:') !!}
    	{!! Form::checkbox('isshow', 'value', old('isshow')) !!}
    <div class="form-group">
    <br/>
    <br/>
    

    <div class="form-group">
		{!! Form::label('Category', 'Category:') !!}
	    <select class="form-control" name="category">
	    @foreach ($sections as $section)
	    <optgroup label=" {{ $section->name }} " >
		    @foreach ($categories as $category)
		    	@if ($category->section_id === $section->id )
                    @if(old('category') === $category->id)
                    <option value="{{ $category->id }}" selected="true"> {{ $category->name }}</option>
                  @else
                    <option value="{{ $category->id }}"> {{ $category->name }}</option>   
                  @endif 
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

</div>
@endsection
