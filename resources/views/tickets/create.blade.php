@if (Auth::check())
	@extends('app')
	@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/jquery-ui-1.11.4.custom/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-te-1.4.0.css">	
<link rel="stylesheet" type="text/css" href="/css/tickets/createticket.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
	<div class="container-fluid">
	<br>
	<div class="row">
	 <div class="col-md-8 col-md-offset-2">
		<div class="panel  ">
			<div class="panel-heading  navbtn txtnav"> <strong>New ticket</strong> </div>
			<div class="panel-body panelbody">
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
			 {!! Form::open(['route'=>'tickets.store','method'=>'post','files' => true]) !!}
			  <div class="row">
				<div class="form-group col-md-6">
					<label class="col-md-4 control-label navtxt">Subject</label>
				    <select class="form-control" name="subject" id="subject_select">
					    @foreach ($subjects as $subject)
					    	<option value="{{ $subject->id }}"<?php if(old('subject') === $subject->id){ echo "selected"; } ?>> {{ $subject->name }}</option>
						@endforeach
					</select>
					<a class="col-md-4 navtxt" onclick="add_new_subject()">Add New</a>
					<div class="col-md-offset-2"  id="subject_new" style="display:none;">
					<br>
						<input type="text" class="form-control col-md-1" id="new_subjvalue"/>
						<a class="btn navbtn txtnav col-md-3" onclick="submit_subject()">Add</a>&ensp;&ensp;
						<a class="btn navbtn txtnav col-md-3" onclick="cancel_subject()">Cancel</a>
					</div>
				</div>
			   </div>

			   <div class="row">
				<div class="form-group col-md-12">
					<textarea class="jqte-test"  name="description">{{ Input::old('description')}}</textarea>
				 </div>
				</div>

				<div class="row">
				 <div class="form-group col-md-6">
					<label class="col-md-4 control-label navtxt">Category</label>
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
				</div>

				@if (Auth::user()->type === "admin")
				<div class="row">
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label navtxt">Priority</label>
					    <select class="form-control" name="priority">
						    <option value="low" <?php if(old('priority') === "low"){ echo "selected"; } ?>>LOW</option>
						    <option value="high" <?php if(old('priority') === "high"){ echo "selected"; } ?>>High</option>
						    <option value="critical" <?php if(old('priority') === "critical"){ echo "selected"; } ?>>Critical</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label navtxt">Due</label>
						<input type="text" id="deadline" name="deadline" class="form-control" value="<?php echo date('Y-m-d H:i:s', strtotime('+1 day')) ?>" />
					</div>
					<div class="form-group col-md-6">
						<label class="col-md-4 control-label navtxt">Assign</label>
					    <select class="form-control" name="tech">
					    	<option value="" selected>Not assigned</option>
						    @foreach ($users as $user)
						    	<option value="{{ $user->id }}" <?php if(old('tech') === $user->id){ echo "selected"; } ?>> {{ $user->fname }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group  col-md-6" id="tags_selected">
						<label class="col-md-4 control-label navtxt">Tags</label>
						<input type="text" id="search" class="form-control">
						<a class="col-md-4 navtxt" onclick="add_new_tag()">Add New Tag</a>
						<div class="row"  id="tag_new" style="display:none;">
							<input type="text" class="form-control col-md-1" id="new_tagvalue"/>
							<a class="btn txtnav navbtn col-md-3" onclick="submit_tag()">Add</a>
							<a class="btn txtnav navbtn col-md-3" onclick="cancel_tag()">Cancel</a>
						</div>
					</div>
					<input type="hidden" name="tagValues" id="tagValues">
			</div>

				@endif

				<div class="row col-md-offset-1">
				    <div class ="form-group">
					    <label class="navtxt">Attach File</label>
					    <input type="file" name="file">
				    </div>
			    </div>
			    <div class="row">
				    <div class="col-md-6 col-md-offset-4">
				    	<button onclick="submit_tags ()" class="btn navbtn txtnav">Submit</button>
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


 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>

 <script >
	$(document).ready(function() {

    $('#deadline').datetimepicker({
  		format:'Y-m-d H:00:00',
      	  });
   
 });
 </script>
 </script>

	@endsection
@endif

