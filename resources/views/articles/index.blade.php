@if (Auth::check())
<html>
<head>

     
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  
     <script src="/js/articles/index.js"></script>

     <link rel="stylesheet" type="text/css" href="/css/articles/index.css">

        
</head>

<body>


<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')

@section('content')
<h1>All Articles </h1>
 <a href="{{url('/articles/create')}}" class="btn btn-success">Create Article</a>

 <!--csv report-->
 <a id="csv" href="articles/csvArticleReport">

    <img src="/images/CSV.png" style="width:40px"></img>

</a>

<!-- Advance Search --> 
<label for="">Category: </label>
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
 <table class="table table-hover " id="con">
     
         <th class="text-center">Subject</th>
         <th class="text-center">category</th>
         <th class="text-center">How can See It!?</th>
         
         <th class="text-center">Owner</th>
         <th class="text-center">created_at</th>
         <th class="text-center">updated_at</th>
         <th class="text-center" colspan="3">Actions</th>
    
     <tbody>
     @foreach ($articles as $article)
         <tr id="{{ $article->id }}">
             <td class="text-center">{{ $article->subject }}</td>
             <td class="text-center">{{ $article->category->name }}</td>
             <td class="text-center">
                @if ($article->isshow==1)
                    Technicals only
                @else
                    Technicals and Users 
                @endif 
             </td>            
             <td class="text-center"> <a href="/users/{{ $article->user_id}}"> {{ $article->user->fname }} {{ $article->user->lname}} </a></td>
             <td class="text-center">{{ $article->created_at }}</td>
             <td class="text-center">{{ $article->updated_at }}</td>
             <td class="text-center"><a href="{{url('articles',$article->id)}}" class="btn btn-primary">Read</a></td>
             <td class="text-center"><a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning">Update</a></td>
             <td class="text-center">
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
