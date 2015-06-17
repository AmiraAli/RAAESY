@extends('app')
@section('content')

<link href="/css/home.css" rel="stylesheet">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="/images/carosel3.png" alt="First slide" style="height:300px; width:100%;">
          <div class="container">
            <div class="carousel-caption">
              <h1> Ticketing System features.</h1>
              <p><h4>The main screen of our Helpdesk Ticketing System features a powerful grid-view showing all the information about  current tickets.</h4></p>
              @if(Auth::user()->type != "tech")
              <p><a class="btn btn-lg navbtn txtnav hv" href="{{ url('/tickets/create') }}" role="button">New Ticket</a></p>
              @endif
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="/images/carosel4.jpg" alt="Second slide" style="height:300px; width:100%;">
          <div class="container">
            <div class="carousel-caption">
              <h1>Everything is neatly organized.</h1>
              <p><h4>Everything related to a ticket is displayed on a single page: the entire conversation, attachments, internal communications and other activity etc.</h4></p>
              @if(Auth::user()->type != "tech")
              <p><a class="btn btn-lg navbtn txtnav" href="{{ url('/tickets/create') }}" role="button">New Ticket</a></p>
              @endif
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="/images/carosel1.jpg" alt="Third slide" style="height:300px; width:100%;">
          <div class="container">
            <div class="carousel-caption">
              <h1>Reports.</h1>
              <p><h4>Our Reports make it easy to keep an eye on your team performance.</h4></p>
              @if(Auth::user()->type != "tech")
              <p><a class="btn btn-lg navbtn txtnav" href="{{ url('/tickets/create') }}" role="button">New Ticket</a></p>
             @endif
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->
<div  class="container">

<br><br>
  <div class="col-md-12"> 
    <div class="col-xs-12 col-md-3">
      <div class="row" id="category_list">
        <div class="list-group">

          <a href="#" class="list-group-item active" id="cat_all" onclick="searchByCat('cat_all', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ $countArticle }}</span><strong>All categories</strong></a>
          @foreach ($categories as $category)
               <a href="#" class="list-group-item" id="cat_{{ $category->category_id }}" onclick="searchByCat('cat_{{ $category->category_id }}', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ $category->count }}</span>{{ $category->name }}</a>                 
            @endforeach       
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-md-9" id="article-show">
      @foreach($articles as $article)
        <div class="col-xs-12 col-md-4 article" > 
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
    </div>
  </div>
</div>



<script type="text/javascript" src="/js/home.js"></script>
<script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
@endsection