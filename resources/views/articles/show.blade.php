@extends('app')
@section('content')
    <h1>Article Show</h1>

    
        <div class="container">
            <label for="subject" class="col-sm-2 control-label">SUBJECT</label>
            <div class="col-sm-10">
                {{$article->subject}}
            </div>
      
       <br/>
       <br/>
        
            <label for="body" class="col-sm-2 control-label">BODY</label>
            <div class="col-sm-10">
                {!!  stripcslashes ($article->body);  !!}
            </div>
        
        <br/>
        <br/>
          
            <label for="isshow" class="col-sm-2 control-label">isshow!?</label>
            <div class="col-sm-10">

                @if ($article->isshow==1)
                   Show for Technicals only
                @else
                    Show for Technicals and Users 
                @endif     
            </div>
    
        <br/>
        <br/>
        
            <label for="category" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10">
                {{$article->category->name}}
            </div>
    
        <br/>
        <br/>
         
            <label for="isshow" class="col-sm-2 control-label">Owner</label>
            <div class="col-sm-10">
                {{$article->user->fname}} {{$article->user->lname}}
            </div>
     
        </div>
@endsection