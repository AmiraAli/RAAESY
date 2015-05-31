@extends('app')
@section('content')
    

    
       <div class="container-fluid">
          <div class="col-md-8">
            <h1>Article Show</h1>
            <label for="subject" class="col-sm-2 control-label">SUBJECT</label>
            <div class="col-sm-10">
                {{$article->subject}}
            </div>
      
       <br/>
       <br/>
        
            <label for="body" class="col-sm-2 control-label">BODY</label>
            <div class="col-sm-10">
                {!!  stripcslashes ($article->body);  !!}
            </div>
        
        <br/>
        <br/>
          
            <label for="isshow" class="col-sm-2 control-label">isshow!?</label>
            <div class="col-sm-10">

                @if ($article->isshow==1)
                   Show for Technicals only
                @else
                    Show for Technicals and Users 
                @endif     
            </div>
    
        <br/>
        <br/>
        
            <label for="category" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10">
                {{$article->category->name}}
            </div>
    
        <br/>
        <br/>
         
            <label for="isshow" class="col-sm-2 control-label">Owner</label>
            <div class="col-sm-10">
                {{$article->user->fname}} {{$article->user->lname}}
            </div>
        <br/>
        <br/>
         
            <label for="Tags" class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10">
               @foreach ($articletags as $articletag)
                 @if($article->id==$articletag->article_id)
                   -{{$articletag->tag->name}}-<br/>   
                 @endif
               @endforeach  
            </div>


        <br/>
        <br/>
        <br/>
        <br/>
        </div>
        <div class="col-md-4">
         <br/>
         <h1>Articles Related</h1>
        <div class="row">
         
            <label for="ReleateArticlesByTags" class="col-sm-2 control-label">ReleateArticlesByTags</label>
            <br/>
            <div class="col-sm-10">

                     
                       @foreach ($tagOfArts as $tagOfArt)
                         
                          @foreach ($articletags as $articletag)
                            @if($tagOfArt->tag_id==$articletag->tag->id)
                               @if($article->id != $articletag->article->id)
                                 <?php $art[]=$articletag->article->id; ?>
                                 <?php $artSub[$articletag->article->id]=$articletag->article->subject; ?>
                                    <!-- <a href="/articles/{{$articletag->article->id}}">{{$articletag->article->subject}}</a> <br/> -->
                                @endif
                            @endif
                           @endforeach
                       @endforeach 


                       <?php

                         $distinct[0]=0;
                         $z=0;
                         for ($i=0; $i <sizeof($art) ; $i++) { 
                             # code...
                            $f=0;
                            for ($j=0; $j <sizeof($distinct) ; $j++) { 
                              # code...
                            
                              if ($distinct[$j] == $art[$i]) {
                                # code...
                                    $f=1;
                                    
                              }

                            }
                            
                            if ($f != 1) {
                              # code...
                              $distinct[$z]=$art[$i];
                              $z=$z+1;
                              echo "<a href=/articles/".$art[$i].">".$artSub[$art[$i]]."</a>"."<br/>";
                               $f=0;
                            }
                         }


                       ?>  
              
            
        </div>
        </div>
        <div class="row">
       
            <label for="ReleateArticlesByCategory" class="col-sm-2 control-label">ReleateArticlesByCategory</label>
            <br/>
            <div class="col-sm-10">

                      {{$article->category->name}}<br/>
                       @foreach ($articles as $art)
                       
                              
                               @if($article->category_id == $art->category_id )
                                   @if($article->id != $art->category_id)
                                        <a href="/articles/{{$art->id}}">{{$art->subject}}</a> <br/>
                                   @endif
                               @endif
                        
                       @endforeach   
              
            </div>
       
        </div>
       </div>
       </div>
@endsection