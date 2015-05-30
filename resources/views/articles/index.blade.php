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
 



<div class="container">
<label for="">Quick Search: </label>
<input type="text" class="glyphicon glyphicon-search parent" onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">

<div id="autocompletemenu" style="display: none;">
   <ul id="autocompleteul"></ul>
</div>
</div>






 <hr>
 <table class="table table-striped table-bordered table-hover">
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
             <td>{{ $article->isshow }}</td>
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