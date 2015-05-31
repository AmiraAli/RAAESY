@extends('app')

@section('content')

<div  class="container">
<div class="row">
<a class="btn btn-primary" href="{{ url('/tickets/create') }}"> New Ticket</a>
</div>
	@foreach($categories as $category)
		<div class="col-md-4" >	
		<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">{{$category->section->name}}/{{$category->name}}</h3>
			  </div>
			@foreach($articles as $article)
					@if($category->id == $article->category_id)

					  <div class="panel-body">
					    <a href="/articles/{{$article->id}}">{{$article->subject}}</a> <br/>
		
					    {{substr($article->body,0,10)."....."}}
					  </div>

					@endif
		    @endforeach
		    </div>
		</div>    
	@endforeach
		
</div>


@endsection