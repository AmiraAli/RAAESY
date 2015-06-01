
@extends('app')

@section('content')


<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">


<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css"> 
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" /> 




	{!! Form::open(array('class' => 'form-inline', 'method' => 'PATCH', 'route' => array('articles.update',$article->id))) !!}
	
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


    <div class="form-group">
        {!! Form::label('SUBJECT', 'SUBJECT:') !!}
        {!! Form::text('subject',$article->subject,['class'=>'form-control']) !!}
    </div>
    <br/>
   <div class="form-group">
        {!! Form::label('BODY', 'BODY:') !!}
        {!! Form::textarea('body',$article->body,['class'=>'jqte-test']) !!}
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
        </div>
    <br/>


    <!-- Tag -->
     <div class="form-group" id="tags_selected">
        <label class="control-label">Tags</label>
        <input type="text" id="search" class="form-control">  
        <input type="hidden" name="tagValues" id="tagValues">
     </div>
    <br><br>




    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>


	{!! Form::close() !!}


    <script>
         $('.jqte-test').jqte();
    </script>

    <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
    <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
    <script type="text/javascript" src="/js/articles/tags.js"></script>


@endsection