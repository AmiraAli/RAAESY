<html>
<head>

<style>
	span{

		display: block;
		float:right;

	}
</style>
	

        
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')


<div class="container">

<div  id="con" class="col-md-12" >
@foreach ($logs as $log  )
 <div class="row" >
 	<div class="panel panel-default">

 	<div class="panel-heading">Done by: <b>{{ ucfirst ($log->user->fname) }}</b> 
 	<span> 		
 	
	{{ $log->created_at }} </span></div>

 	<div class="panel-body">
 	<?php $name ='p'; ?>

 	@if ( $log->type == 'user')
             <?php $name='name'; ?>                  
  	@elseif ( $log->type == 'article')
			<?php $name = 'title'; ?>
	@else
			<?php $name = 'subject'; ?>
	@endif


 	{{$log->user->fname}}

	@if ( $log->action == 'spam')
		marked the {{$log->type}} #{{$log->id}} with {{$name}} "{{$log->name}}" as spam
	
	@else
		{{$log->action}}d the {{$log->type}} #{{$log->id}} with {{$name}} "{{$log->name}}"
	@endif

 	
	</div>

</div>

	</div>
	
@endforeach


</div>



		</div>
			</div>
				</div>				
</div>



@stop

</body>
</html>
