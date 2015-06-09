@foreach($articles as $article)
	<div class="col-md-4 article" >	
		<div class="panel panel-info">
<<<<<<< HEAD
	  		<div class="panel-body"  id="articles">	
	  			<a href="/articles/{{$article->id}}"><strong>{{$article->subject}}</strong></a><br>		    			
=======

	  		<div class="panel-body" >	
	  			<a  class="navtxt" href="/articles/{{$article->id}}"><strong>{{$article->subject}}</strong></a><br>		    			
>>>>>>> c4ab86c0c8fe713c08d87651d78d753fdd1c8908
		    	@if (strlen($article->body) <= 100)
		    		{{ $article->body }}
		    	@else
		    		{{substr(strip_tags($article->body),0,100)." ...."}}
		    	@endif
		 	</div>			
	    </div>
	</div>    
@endforeach