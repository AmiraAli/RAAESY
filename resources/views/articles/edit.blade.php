
@extends('app')

@section('content')


<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">


<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/text_editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="/css/text_editor/jquery-te-1.4.0.css">
<link href="/css/articles/edit.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css"> 
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" /> 


<div class="container-fluid">
<br><br><br>
  <div class="row">
   <div class="col-md-7 col-md-offset-2">
    <div class="panel ">
      <div class="panel-heading navbtn txtnav"> <strong>Edit Article</strong> </div>
      <div class="panel-body">
  
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
  <div class="row">
      <div class="form-group col-md-6">
          {!! Form::label('SUBJECT', 'Subject', ['class'=> 'col-md-4 control-label navtxt']) !!}

          {!! Form::text('subject',$article->subject,['class'=>'form-control']) !!}
      </div>
       <div class="form-group col-md-6">
          {!! Form::label('Category', 'Category', ['class'=> 'col-md-4 control-label navtxt']) !!}
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
    </div>
    <div class="row">
        <div class="form-group col-md-11">
        {!! Form::textarea('body',$article->body,['class'=>'jqte-test']) !!}
        </div>
    </div>

   
  <div class="form-group  col-md-6" id="tags_selected">
       <label class="col-md-4 control-label navtxt">Tags</label>
       <input type="text" id="search" class="form-control">
  </div>
  <input type="hidden" name="tagValues" id="tagValues">
<div class="form-group">
      {!! Form::label('IS SHOW', 'For Technical Only',['class'=> ' navtxt']) !!}
      @if ($article->isshow == 1)
            {!! Form::checkbox('isshow', 'value') !!}
        @else
            {!! Form::checkbox('isshow', 'value',true) !!}
        @endif
    </div >
    <br><br>
<div class="row">
            <div class="col-md-6 col-md-offset-4">
              <button onclick="submit_tags ()" class="btn navbtn txtnav" style="color: #ffffff !important;">Submit</button>
            </div>
  </div>

        {!! Form::close() !!}


</div>
</div>
</div>
</div>
</div>
    <script>
         $('.jqte-test').jqte();
    </script>
    <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
    <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
    <script type="text/javascript" src="/js/articles/tags.js"></script>


@endsection