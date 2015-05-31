

<table class="table table-striped table-bordered table-hover">
     <thead>
     <tr class="bg-info">
         <th>Id</th>
         <th>Subject</th>
         <th>Body</th>
         <th>Is Show !?</th>
         <th>category_id</th>
         <th>user_id</th>
         <th>created_at </th>
         <th>updated_at </th>
         <th colspan="3">Actions</th>
     </tr>
     </thead>
     <tbody>


         @foreach ($articleTags as $articleTag)
            @foreach ($articles as $article)
               @if($articleTag->article_id==$article->id)
                 <tr id="{{ $articleTag->article_id }}">
                     <td>{{$articleTag->article_id}}</td>
                     <td>{{ $article->subject }}</td>
                     <td>{!!  stripcslashes ($article->body);  !!}</td>
                     <td>
                        @if ($article->isshow==1)
                            Technicals only
                        @else
                            Technicals and Users 
                        @endif 
                     </td>
                     <td>{{ $article->category->name }}</td>
                     <td>{{ $article->user->fname }}</td>
                     <td>{{ $article->created_at }}</td>
                     <td>{{ $article->updated_at }}</td>
                     <td><a href="{{url('articles',$article->id)}}" class="btn btn-primary">Read</a></td>
                     <td><a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning">Update</a></td>
                     <td>
                     <button onclick="Delete({{ $article->id }});" class="btn btn-danger"> Delete </button>
                     </td>
             
                 </tr>
                @endif
             @endforeach
         @endforeach
    

     </tbody>

 </table>

