@extends('app')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  
<script src="/js/articles/index.js"></script>
<link rel="stylesheet" type="text/css" href="/css/articles/index.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

<div class="container">
    <br>
    <div class="row">
        <div id="search">
            <div class="form-group">
                <label class="col-md-3 control-label navtxt"><b>Quick Search</b></label>
                <div class="col-md-6"> 
                    <input type="text" class="form-control glyphicon glyphicon-search parent" placeholder="subject...." onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">

                    <div id="autocompletemenu" style="display: none;">
                       <ul id="autocompleteul"></ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="new-article">
                     <!--csv report-->
            <a id="csv" href="articles/csvArticleReport">
                <img src="/images/CSV.png" style="width:40px"></img>
            </a>
            <a href="{{url('/articles/create')}}" class="btn btn-success">Create Article</a>
        </div>
    </div>

    <br>
    <div class="col-md-11" id="cat-tag">
        <div class="panel ">
            <div class="panel-heading navbtn txtnav">
                <h3 class="panel-title">Search</h3>
            </div>
            <div class="panel-body">
                <div class="form-group col-md-4">
                    <label class="col-md-3 control-label">Category</label>
                    <div class="col-md-7">
                        <select class="form-control" name="category" id="cat">
                            <option value="0" selected="true"> Select Category</option>
                            @foreach ($sections as $section)
                            <optgroup label=" {{ $section->name }} " >
                                @foreach ($categories as $category)
                                    @if ($category->section_id === $section->id )
                                        @if(old('category') === $category->id)
                                            <option value="{{ $category->id }}" selected="true"> {{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}"> {{ $category->name }}</option>   
                                        @endif 
                                    @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-5">
                    <label class="col-md-1 control-label">Tag</label>
                    <div class="col-md-6">
                        <select class="form-control" name="tag" id="tag">
                            <option value="0" selected="true"> Select Tags</option>
                            @foreach ($tags as $tag)          
                                @if(old('tag') === $tag->id)
                                    <option value="{{ $tag->id }}" selected="true"> {{ $tag->name }}</option>
                                @else
                                    <option value="{{ $tag->id }}"> {{ $tag->name }}</option>   
                                @endif 
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                    <button class="btn btn-primary" onclick="show()">Search</button>
                </div>
            </div>
        </div>
    </div>

    




  




    <div class="col-md-11" id="table_show">  
        <table class="table table-hover" id="con">
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
                 @foreach ($articles as $article)
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
                 @endforeach
             </tbody>
         </table>
    </div>
</div>

<script type="text/javascript" src="/js/deleteArticle.js"></script>

@endsection


