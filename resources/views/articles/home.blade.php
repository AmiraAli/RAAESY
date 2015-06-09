@extends('app')

@section('content')

<div  class="container">
@if(Auth::user()->type == "admin")
	<div class="row">
	<a class="btn btn-primary" href="{{ url('/tickets/create') }}"> New Ticket</a>
	</div>
	<br>
@endif
<div class="row">
	@foreach($categories as $category)
		<div class="col-md-4" >	
		<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">{{$category->section->name}}/{{$category->name}}</h3>
			  </div>
			@foreach($articles as $article)
					@if($category->id == $article->category_id)
                      @if($article->isshow==1)
                      	 @if(!$current_user->type=='regular')
						  <div class="panel-body">
						    <a href="/articles/{{$article->id}}">{{$article->subject}}</a> <br/>		
						    {{substr(strip_tags($article->body),0,10)."....."}}
						  </div>
						  @endif
					  @endif
					@endif
		    @endforeach
		    </div>
		</div>    
	@endforeach
</div>
		
</div>


@endsection