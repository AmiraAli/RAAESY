@extends('app')
@section('content')

<link href="/css/home.css" rel="stylesheet">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<div  class="container">
	<br>
	@if(Auth::user()->type != "tech")
		<div class="row" id="new-ticket">
			<a class="btn btn-primary" href="{{ url('/tickets/create') }}"> New Ticket</a>
		</div>
	@endif
	<br>
	<div class="col-md-12">	
		<div class="col-md-2">
			<div class="row" id="category_list">
				<div class="list-group">
					<a href="#" class="list-group-item active" id="cat_all" onclick="searchByCat('cat_all', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><strong>All categories</strong></a>
					@foreach ($sections as $section)
						<a href="#" class="list-group-item" id="sec_{{ $section->id }}" onclick="searchByCat('sec_{{ $section->id }}', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"> &nbsp &nbsp<strong>{{ $section->name }}</strong></a>
						@foreach ($section->categories as $category)
							<a href="#" class="list-group-item" id="cat_{{ $category->id }}" onclick="searchByCat('cat_{{ $category->id }}', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"> &nbsp &nbsp &nbsp &nbsp{{ $category->name }}</a>
						@endforeach	        			         
				    @endforeach				  
				</div>
			</div>
		</div>
		<div class="row" id="article-show">
			@foreach($articles as $article)
				<div class="col-md-3 article" >	
					<div class="panel panel-info">
	
				  		<div class="panel-body" >	
				  			<a href="/articles/{{$article->id}}"><strong>{{$article->subject}}</strong></a><br>		    			
					    	@if (strlen($article->body) <= 100)
					    		{{ $article->body }}
					    	@else
					    		{{substr(strip_tags($article->body),0,100)." ...."}}
					    	@endif
					 	</div>			
				    </div>
				</div>    
			@endforeach
		</div>
	</div>
</div>



<script type="text/javascript" src="/js/home.js"></script>
<script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
@endsection