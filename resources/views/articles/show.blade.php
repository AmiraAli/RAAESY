@extends('app')
@section('content')
<link href="/css/articles/showArticle.css" rel="stylesheet">
<br><br>
<div class="container ">

  <img  class="col-xs-10 col-md-5 pull-right visible-xs hidden-md visible-sm  hidden-lg" src="/images/helpdeskArticle.png">
    <div class=" col-xs-11 col-md-7">
      <div class="panel ">
      <div class="panel-heading navbtn txtnav fnt" >{{$article->subject}}
        </div>
        <div class="panel-body">
        @if(Auth::user()->type == "admin")
           <span class="write"><h2><small>By&ensp;{{$article->user->fname}} {{$article->user->lname}}</small></h2> </span>
        @endif
            <span class="write">
                {!!  stripcslashes ($article->body);  !!}
          </span>
            </div>
          </div>
      </div>
      
 <div class=" col-xs-11 col-md-4 pull-right" >

 <div class="row ">
<img  class="col-xs-10 col-md-12 visible-md visible-lg hidden-xs hidden-sm visible-lg pull-right" src="/images/helpdeskArticle.png">
 </div>

    <div class="row ">
    <div class="col-md-12">
  
      <div class="panel">
        <div class="panel-heading navbtn txtnav fnt" > Related Articles By Tags
        </div>

        <div class="panel-body">
                       @foreach ($tagOfArts as $tagOfArt)
                         
                          @foreach ($articletags as $articletag)
                            @if($tagOfArt->tag_id==$articletag->tag->id)
                               @if($article->id != $articletag->article->id)
                                 <?php $art[]=$articletag->article->id; ?>
                                 <?php $artSub[$articletag->article->id]=$articletag->article->subject; ?>
                              
                                @endif
                            @endif
                           @endforeach
                       @endforeach 


                       <?php

                         $distinct[0]=0;
                         $z=0;
                         if (!empty($art)) {

                         for ($i=0; $i <sizeof($art) ; $i++) { 
                             
                            $f=0;
                            for ($j=0; $j <sizeof($distinct) ; $j++) { 
                              
                            
                              if ($distinct[$j] == $art[$i]) {
                                
                                    $f=1;
                                    
                              }

                            }
                            
                            if ($f != 1) {
                              
                              $distinct[$z]=$art[$i];
                              $z=$z+1;

                              echo "<a href=/articles/".$art[$i].">".$artSub[$art[$i]]."</a>"."<br/>";
                              $f=0;
                            }
                         }
                       }

                       ?>  

        </div></div></div>
   </div>

           <div class="row ">
             <div class="col-md-12">
  
   
      <div class="panel">
        <div class="panel-heading navbtn txtnav fnt" >Related Articles By Category (&ensp;{{$article->category->name}}&ensp;)
        </div>

        <div class="panel-body">

                    <?php $x=0;?>
                       @foreach ($articles as $art)
                       
                              
                               @if($article->category_id == $art->category_id )

                                   @if($article->id != $art->id)
                                   @if ($x<5)
                                        <a href="/articles/{{$art->id}}">{{$art->subject}}</a>
                                         <br/>
                                    <?php $x++;?>
                                    @endif
                                    @if ($x==5)
                                      <span class="dt">....</span>
                                      <?php $x++;?>
                                   @endif
                                   @endif
                               @endif
                        
                       @endforeach
       </div>
      </div>
       </div>
       </div>
       </div> 
        </div>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

@endsection