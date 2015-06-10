@foreach($articles as $article)
	<div class="col-md-4 article" >	
		<div class="panel panel-info">
	  		<div class="panel-body"  id="articles">	
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