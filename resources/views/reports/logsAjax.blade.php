<center><?php echo $logs->render(); ?></center>
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

