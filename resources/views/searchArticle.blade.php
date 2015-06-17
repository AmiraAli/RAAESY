@foreach($articles as $article)
    <div class="col-md-4 article" > 
      <div class="panel panel-info">
          <div class="panel-body"  id="articles"> 
            <a href="/articles/{{$article->id}}"><strong>{{$article->subject}}</strong></a><br>             
            @if (strlen($article->body) <= 70)
              {!! $article->body !!}
            @else
              {!! substr(strip_tags($article->body),0,70)." <b>.......</b>" !!}
            @endif
        </div>      
      </div>
    </div>    
  @endforeach
 <div class="col-md-12">
    <center> <?php echo $articles->render(); ?></center>
</div> 