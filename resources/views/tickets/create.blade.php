
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
			 {!! Form::open(['route'=>'tickets.store','method'=>'post']) !!}

				<div class="form-group col-md-6">
					<label class="col-md-4 control-label">Subject</label>
				    <select class="form-control" name="subject" id="subject_select">
					    @foreach ($subjects as $subject)
					    	<option value="{{ $subject->id }}"> {{ $subject->name }}</option>
						@endforeach
					</select>
					<a class="col-md-4" onclick="add_new_subject()">Add New</a>
					<div class="row"  id="subject_new" style="visibility:hidden;">
						<input type="text" class="form-control col-md-2" id="new_subjvalue"/>
						<a class="btn btn-primary col-md-2" onclick="submit_subject()"> add</a>
					</div>
				</div>

				<div class="form-group">
					<textarea class="jqte-test" rows="3" name="description"></textarea>
				</div>

				<div class="form-group col-md-6">
					<label class="col-md-4 control-label">Category</label>
				    <select class="form-control" name="category">
				    @foreach ($sections as $section)
				    <optgroup label=" {{ $section->name }} " >
					    @foreach ($categories as $category)
					    	@if ($category->section_id === $section->id )
					    		<option value="{{ $category->id }}" > {{ $category->name }}</option>
					    	@endif
						@endforeach
					</optgroup>
					@endforeach
					</select>
				</div>

				@if (Auth::user()->type === "admin")
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label">Priority</label>
					    <select class="form-control" name="priority">
						    <option value="low">LOW</option>
						    <option value="high">High</option>
						    <option value="critical">Critical</option>
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
						    	<option value="{{ $user->id }}"> {{ $user->fname }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group  col-md-6" id="tags_selected">
						<label class="col-md-4 control-label">Tags</label>
						<input type="text" id="search" class="form-control">
					</div>
					<input type="hidden" name="tagValues" id="tagValues">
				@endif

			    <div class ="form-group">
				    <label >Attach File</label>
				    <input type="file" name="file">
			    </div>

			    <div class="col-md-6 col-md-offset-4">
			    	<button type="submit" class="btn btn-primary">Submit</button>
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

