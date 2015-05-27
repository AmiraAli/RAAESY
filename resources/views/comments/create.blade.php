@extends('app')

@section('content')

<style>
span{

	display: block;
	float:right;

}
</style>

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2" id="comments">
			
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif



@foreach ($ticket->comments as $comment  )
 <div class="row" id={{$comment->id}}>
 	<div class="panel panel-default">

 	<div class="panel-heading"><b>{{ $comment->user->name }}</b> 
 	<span> 		
 	@if ($comment->updated_at  != $comment->created_at )
 	Edited:   
	@endif
	{{ $comment->updated_at }} </span></div>

 	<div class="panel-body">

 	<p>{{ $comment->body }}</p>
	<button name={{$comment->id}}_{{$ticket->id}} onclick="edit(this)" class="btn btn-primary" data-token="{{ csrf_token() }}"   >Edit</button>
	<button name={{$comment->id}}_{{$ticket->id}} onclick="Delete(this)" class="btn btn-primary"   >Delete</button>
	</div>

</div>

	</div>
	
@endforeach

				
				</div>
			</div>
		
</div>


	<form name="addForm" method = 'post'  class = 'form-horizontal' action="javascript:add({{$ticket->id}})">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<div class="col-md-6">
					<textarea type="text" class="form-control" name="body" ></textarea>
				</div>
			</div>

		

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button    type="submit"  class="btn btn-primary">
						Add comment
					</button>
				</div>
			</div>
	</form>





<script src="/js/comments.js"></script>

@endsection
