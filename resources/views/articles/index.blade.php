<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')

@section('content')

<h1>Articles ^_^ :))</h1>
 <a href="{{url('/articles/create')}}" class="btn btn-success">Create Article</a>
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
             <td>{{ $article->body }}</td>
             <td>{{ $article->isshow }}</td>
             <td>{{ $article->category_id }}</td>
             <td>{{ $article->user_id }}</td>
             <td>{{ $article->created_at }}</td>
             <td>{{ $article->updated_at }}</td>
             <td><a href="{{url('articles',$article->id)}}" class="btn btn-primary">Read</a></td>
             <td><a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning">Update</a></td>
             <td>
             <!-- {!! Form::open(['method' => 'DELETE', 'route'=>['articles.destroy', $article->id]]) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
             {!! Form::close() !!} -->
             <button onclick="Delete({{ $article->id }});" class="btn btn-danger"> Delete </button>
             </td>
             
             
         </tr>
     @endforeach

     </tbody>

 </table>


@endsection
<script type="text/javascript" src="/js/deleteArticle.js"></script>