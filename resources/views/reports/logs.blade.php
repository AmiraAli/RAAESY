<html>
<head>

<style>
	span{

		display: block;
		float:right;

	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  


	  
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')
<div class="container">
	<h3 class="navtxt"><a href="{{ url('/reports')}}"> Reports</a>
	>>Deletion Log</h3>
</div>
<div class="container">
<br>

<?php echo $logs->render(); ?>
<a  class="row pull-right" id="csv" href="/reports/logsCSV" >

    <img src="/images/CSV.png" style="width:40px"></img>

</a>

<div  id="con" class="col-md-12" >
@foreach ($logs as $log  )
 <div class="row" >
 	<div class="panel">

	<?php if (preg_match("/^.*[a-z].*$/i", $log->user->fname )){ ?>
 		<div class="panel-heading navbtn txtnav "><span class="admin pull-left" >{{ trans('words.Done_by' , ['admin' => ucfirst($log->user->fname) ]) }}</span>
 	<?php }else{ ?>
		<div class="panel-heading navbtn txtnav"><span class="admin pull-left" >{{ trans('words.Done_by_ar' , ['admin' => ucfirst($log->user->fname) ]) }} </span>
 	<?php } ?>
 	<span class="date"> 		
 	
	{{ $log->created_at }} </span></div>

 	<div class="panel-body">
 	<?php $name =''; ?>

 	@if ( $log->type == 'user')
			 <?php $type= trans('words.user') ?>                  
             <?php $name= trans('words.name') ?> 

  	@elseif ( $log->type == 'article')
  			<?php $type= trans('words.article') ?>                  
			<?php $name = trans('words.title') ?>                  

	@elseif ( $log->type == 'category')
	  		<?php $type= trans('words.category') ?>                  
			<?php $name =  trans('words.Subject') ?>                  

	@elseif ( $log->type == 'asset')
	  		<?php $type= trans('words.asset') ?>                  
			<?php $name =  trans('words.Subject') ?> 
	@else 									 <!-- Ticket -->
			
			<?php $type= trans('words.ticket') ?>                  
			<?php $name =  trans('words.Subject') ?> 
	@endif 

	
	@if ( $log->action == 'spam')

	<?php if (preg_match("/^.*[a-z].*$/i", $log->name )){ ?>

		{{ trans('words.spam_msg', ['admin' => $log->user->fname , 'type' => $type ,    'id' => $log->id ,'title'=>$name  , 'name'=>  $log->name ]  ) }} 
	
	<?php }else{ ?>

		{{ trans('words.spam_msg_ar', ['admin' => $log->user->fname , 'type' => $type ,    'id' => $log->id ,'title'=>$name  , 'name'=>  $log->name ]  ) }} 
	<?php } ?>

	@else
		<?php if (preg_match("/^.*[a-z].*$/i", $log->name )){ ?>

		{{ trans('words.delete_msg', ['admin' => $log->user->fname , 'type' => $type ,    'id' => $log->id ,'title'=>$name , 'name'=>  $log->name  ]  ) }} 
		<?php }else{ ?>
	 		{{ trans('words.delete_msg_ar', ['admin' => $log->user->fname , 'type' => $type ,    'id' => $log->id ,'title'=>$name  , 'name'=>  $log->name ]  ) }} 

		<?php } ?>
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



 <script >


  window.onload = function() {

	 if ( "<?php echo Session::get('locale') ; ?>" == 'ar'){
 		$('.admin').attr("class",'pull-right');
 		$('.date').attr("class",'pull-left');
 		$(".panel").css({
			overflow: "hidden",
		});
 		$(".panel-body").css({
			float:'right',
		});
 	}
	 

	$(".panel-heading").css({
		overflow: "hidden",
	});

 	
}

 </script>  


@stop

</body>
</html>
