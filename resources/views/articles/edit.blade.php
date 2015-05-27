
@extends('app')

@section('content')
	{!! Form::open(array('class' => 'form-inline', 'method' => 'PATCH', 'route' => array('articles.update',$article->id))) !!}
	<div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}
        {!! Form::text('subject',$article->subject,['class'=>'form-control']) !!}
    </div>
    <br/>
    <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        {!! Form::text('body',$article->body,['class'=>'form-control']) !!}
    </div>
    <br/>

    <div class="form-group">
        {!! Form::label('IS SHOW', 'IS SHOW:') !!}
        @if ($article->isshow == 1)
            {!! Form::checkbox('isshow', 'value') !!}
        @else
            {!! Form::checkbox('isshow', 'value',true) !!}
        @endif

    </div>
    <div class="form-group">
        <select class="form-control" name="category">
        @foreach ($sections as $section)
        <optgroup label=" {{ $section->name }} " >
            @foreach ($categories as $category)
              @if ($category->section_id === $section->id )
                  @if($article->category_id === $category->id)
                    <option value="{{ $category->id }}" selected="true"> {{ $category->name }}</option>
                  @else
                    <option value="{{ $category->id }}"> {{ $category->name }}</option>   
                  @endif   
              @endif     
            @endforeach
            </optgroup>
        @endforeach
        </select>
    <br/>
    
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>


	{!! Form::close() !!}

@endsection