@extends('app')
@section('content')
<link href="/css/articles/showArticle.css" rel="stylesheet">
      {{--  <div class="container-fluid">
          <div class="col-md-8">
            <div class="panel-heading">
            <h3 class="panel-title">Article Show</h3></div>
            <label for="subject" class="col-sm-2 control-label">SUBJECT</label>
            <div class="col-sm-10">
                {{$article->subject}}
            </div> --}}
<br><br>
<div class="container ">
<div class="col-md-9 ">
  <div class="row ">
    <div class="col-md-4">
      <div class="panel">
        <div class="panel-heading navbtn txtnav fnt" >{{$article->subject}}
        </div>

        <div class="panel-body">
        <span class="write">By&ensp;{{$article->user->fname}} {{$article->user->lname}} </span>
        {{-- Category&ensp;{{$article->category->name}} --}}

        <br/>
        </div></div></div></div>

 <div class="row ">
    <div class="col-md-11">
      <div class="panel ff">
<div class="panel-body">
           
            <span class="write">
                {!!  stripcslashes ($article->body);  !!}
          </span>
            </div></div></div></div></div>
    
         
          {{--   <label for="Tags" class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10">
               @foreach ($articletags as $articletag)
                 @if($article->id==$articletag->article_id)
                   -{{$articletag->tag->name}}-<br/>   
                 @endif
               @endforeach  
            </div> --}}

        
 <div class="col-md-3 my">
     <span class="fntt">Related Articles</span><br>
    <div class="row ">
    <div class="col-md-12">
  
      <div class="panel">
        <div class="panel-heading navbtn txtnav fnt" >By Tags
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
                         $y=0;
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

                              if ($y<5)
                                {       
                               $y++;

                              echo "<a href=/articles/".$art[$i].">".$artSub[$art[$i]]."</a>"."<br/>";
                              if ($y==5)
                              {
                                      echo '<span class="dt">....</span>';
                                     $y++;
                                  } 
                            }
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
        <div class="panel-heading navbtn txtnav fnt" >By Category (&ensp;{{$article->category->name}}&ensp;)
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
                       </div></div></div></div></div>  </div>

@endsection