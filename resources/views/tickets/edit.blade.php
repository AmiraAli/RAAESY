
@if (Auth::check())
	@extends('app')
	@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">	
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
	<div class="container-fluid">
	<div class="row">
	 <div class="col-md-8 col-md-offset-2">
		<div class="panel panel-danger">
			<div class="panel-heading"> <strong>New ticket</strong> </div>
			<div class="panel-body">
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
			 {!! Form::open(['route'=>['tickets.update',$ticket->id],'method'=>'put']) !!}
			  <div class="row">
				<div class="form-group col-md-6">
					<label class="col-md-4 control-label">Subject</label>
				    <select class="form-control" name="subject" id="subject_select">
					    @foreach ($subjects as $subject)
					    	@if($ticket->subject_id === $subject->id)
						    	<option value="{{ $subject->id }}" selected="true"> {{ $subject->name }}</option>
							@else
							    <option value="{{ $subject->id }}"> {{ $subject->name }}</option>	
							@endif
						@endforeach
					</select>
				</div>
				<div class="col-md-6">
					<a class="col-md-4" onclick="add_new_subject()">Add New</a>
					<div class="col-md-offset-2"  id="subject_new" style="visibility:hidden;">
						<input type="text" class="form-control col-md-1" id="new_subjvalue"/>
						<a class="btn btn-primary col-md-3" onclick="submit_subject()">Add</a>
						<a class="btn btn-primary col-md-3" onclick="cancel_subject()">Cancel</a>
					</div>
				</div>
			   </div>

			   <div class="row">
				<div class="form-group col-md-12">
					<textarea class="jqte-test"  name="description">{!! $ticket->description !!}</textarea>
				 </div>
				</div>

				<div class="row">
				 <div class="form-group col-md-6">
					<label class="col-md-4 control-label">Category</label>
				    <select class="form-control" name="category">
				    @foreach ($sections as $section)
				    <optgroup label=" {{ $section->name }} " >
					    @foreach ($categories as $category)
					    	@if ($category->section_id === $section->id )
					    		@if($ticket->category_id === $category->id)
							    	<option value="{{ $category->id }} " selected="true"> {{ $category->name }}</option>
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

				@if (Auth::user()->type === "admin")
				<div class="row">
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label">Priority</label>
					    <select class="form-control" name="priority">
						    @if ($ticket->priority === "low" )
						      <option value="low" selected="true">LOW</option>
						    @else
						    	<option value="low" >LOW</option>
						    @endif
						    @if ($ticket->priority === "high" )
						      <option value="high" selected="true">High</option>
						    @else
						    	<option value="high">High</option>
						    @endif
						    @if ($ticket->priority === "critical" )
						      <option value="critical" selected="true">Critical</option>
						    @else
						      <option value="critical">Critical</option>
						    @endif
						</select>
					</div>
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label">Due</label>
						<input type="date" name="deadline" class="form-control" />
					</div>
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label">Assign</label>
					    <select class="form-control" name="tech">
						    @foreach ($users as $user)
						    	@if ($ticket->tech_id == $user->id)
						    		<option value="{{ $user->id }}" selected="true"> {{ $user->fname }}</option>
						    	@else
						    		<option value="{{ $user->id }}"> {{ $user->fname }}</option>
						    	@endif
							@endforeach
						</select>
					</div>

					<div class="form-group  col-md-6" id="tags_selected">
						<label class="col-md-4 control-label">Tags</label>
						<input type="text" id="search" class="form-control">
					</div>
					<input type="hidden" name="tagValues" id="tagValues">
				</div>
				@endif

				<div class="row col-md-offset-1">
				    <div class ="form-group">
					    <label >Attach File</label>
					    <input type="file" name="file">
				    </div>
			    </div>
			    <div class="row">
				    <div class="col-md-6 col-md-offset-4">
				    	<button type="submit" class="btn btn-primary">Submit</button>
				    </div>
			    </div>

			  {!! Form::close() !!}
			 </div>
		   </div>
		 </div>
		</div>
	</div>
 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
 <script type="text/javascript" src="/js/ticket_form.js"></script>
	@endsection
@endif

