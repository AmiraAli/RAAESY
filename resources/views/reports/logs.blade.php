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

@if (Session::get('lang') =="ar")
	<a  href="/reports/logs?lang=en" class="btn navbtn txtnav" >English</a>
@else
	<a  href="/reports/logs?lang=ar" class="btn navbtn txtnav" >عربى</a>
@endif 

<div class="container">

<a id="csv" href="/reports/logsCSV" >

    <img src="/images/CSV.png" style="width:40px"></img>

</a>

<div  id="con" class="col-md-12" >
@foreach ($logs as $log  )
 <div class="row" >
 	<div class="panel panel-default">

 	<div class="panel-heading">{{ trans('words.Done_by') }}: <b>{{ ucfirst ($log->user->fname) }}</b> 
 	<span> 		
 	
	{{ $log->created_at }} </span></div>

 	<div class="panel-body">
 	<?php $name =''; ?>

 	@if ( $log->type == 'user')
             <?php $name= trans('words.name') ?>                  
  	@elseif ( $log->type == 'article')
			<?php $name = trans('words.title') ?>                  
	@else
			<?php $name =  trans('words.subject') ?>                  
	@endif


 	{{$log->user->fname}}

	@if ( $log->action == 'spam')
		marked the {{$log->type}} #{{$log->id}} {{ trans('words.with') }}{{$name}}"{{$log->name}}" as spam
	
	@else
		{{$log->action}}d the {{$log->type}} #{{$log->id}}  {{ trans('words.with') }}{{$name}} "{{$log->name}}"
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
