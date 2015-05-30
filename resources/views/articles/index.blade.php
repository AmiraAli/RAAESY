@if (Auth::check())
<html>
<head>

     
     
     <script src="/js/articles/index.js"></script>

     <link rel="stylesheet" type="text/css" href="/css/articles/index.css">

        
</head>

<body>


<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')

@section('content')
<h1>Articles ^_^ :))</h1>
 <a href="{{url('/articles/create')}}" class="btn btn-success">Create Article</a>

<!-- Advance Search --> 
<label for="">Category: </label>
<!-- <input type="text" id="cat"> -->

<select  name="category" id="cat">
     <option value="0" selected="true"> Select Category</option>
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


<select  name="tag" id="tag">
    <option value="0" selected="true"> Select Tags</option>
        @foreach ($tags as $tag)
       
        
                
                  @if(old('tag') === $tag->id)
                    <option value="{{ $tag->id }}" selected="true"> {{ $tag->name }}</option>
                  @else
                    <option value="{{ $tag->id }}"> {{ $tag->name }}</option>   
                  @endif 
             
  
        
        @endforeach
</select>




<button onclick="show()">Advance Search</button>



<div  class="container">
<label for="">Quick Search: </label>
<input type="text" class="glyphicon glyphicon-search parent" onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">

<div id="autocompletemenu" style="display: none;">
   <ul id="autocompleteul"></ul>
</div>
</div>






 <hr>
 <table class="table table-striped table-bordered table-hover" id="con">
     <thead>
     <tr class="bg-info">
         <th>Id</th>
         <th>Subject</th>
         <th>Body</th>
         <th>Is Show !?</th>
         <th>category_id</th>
         <th>user_id</th>
         <th>created_at </th>
         <th>updated_at </th>
         <th colspan="3">Actions</th>
     </tr>
     </thead>
     <tbody>
     @foreach ($articles as $article)
         <tr id="{{ $article->id }}">
             <td>{{ $article->id }}</td>
             <td>{{ $article->subject }}</td>
             <td>{!!  stripcslashes ($article->body);  !!}</td>
             <td>
                @if ($article->isshow==1)
                    Technicals only
                @else
                    Technicals and Users 
                @endif 
             </td>
             <td>{{ $article->category->name }}</td>
             <td>{{ $article->user->fname }}</td>
             <td>{{ $article->created_at }}</td>
             <td>{{ $article->updated_at }}</td>
             <td><a href="{{url('articles',$article->id)}}" class="btn btn-primary">Read</a></td>
             <td><a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning">Update</a></td>
             <td>
             <button onclick="Delete({{ $article->id }});" class="btn btn-danger"> Delete </button>
             </td>
             
             
         </tr>
     @endforeach

     </tbody>

 </table>


@endsection
<script type="text/javascript" src="/js/deleteArticle.js"></script>

</body>
</html>
@endif