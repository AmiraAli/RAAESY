

<table class="table table-hover " id="con">
    <thead>
        <tr class="info">
             <th class="text-center">Subject</th>
             <th class="text-center">category</th>
             <th class="text-center">For</th>
             
             <th class="text-center">Owner</th>
             <th class="text-center">Date</th>
             <th class="text-center" colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>

         @foreach ($articleTags as $articleTag)
            @foreach ($articles as $article)
               @if($articleTag->article_id==$article->id)
                 <tr id="{{ $article->id }}">
                         <td class="text-center"><a href="/articles/{{ $article->id}}"><b>{{ $article->subject }}</b></a></td>
                         <td class="text-center">{{ $article->category->name }}</td>
                         <td class="text-center">
                            @if ($article->isshow==0)
                                Technicals only
                            @else
                                Technicals and Users 
                            @endif 
                         </td>            
                         <td class="text-center"> <a href="/users/{{ $article->user_id}}"><b>{{ $article->user->fname }} {{ $article->user->lname}}</b></a></td>
                         <td class="text-center">{{ $article->created_at }}</td>
                         <td>
                             <a href="{{route('articles.edit',$article->id)}}" class="do"><img src="/images/edit.png" width="30px" height="30px">   </a>
                                        &ensp;&ensp; &ensp;
                             <a href="#" onclick="Delete({{ $article->id }});" ><img src="/images/delete.png" width="30px" height="30px"></a>
                         </td>
                     </tr>
                @endif
             @endforeach
         @endforeach
    

     </tbody>

 </table>

