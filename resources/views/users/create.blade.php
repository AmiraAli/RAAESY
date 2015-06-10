@extends('app')
@section('content')
<div class="container-fluid">

<br>
<a  href="/users/create?lang=ar" class="btn navbtn txtnav" >عربى</a>
<a  href="/users/create?lang=en" class="btn navbtn txtnav" >English</a>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel ">
				<div class="panel-heading navbtn txtnav" style="height:35px;"><span id="header">{{ trans('words.add_user') }}</span></div>
				<div class="panel-body">
				    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong> {{ trans('words.ooh') }} </strong> {{ trans('words.validError') }}<br><br>
                            <ul>
                                @foreach ($errors->all() as $key => $error )
                                    <li>{{ $error  }}</li>
                                @endforeach
                            </ul>
                        </div>
       				@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/users/') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">


						<div class="form-group">
							<label class="col-md-4 control-label navtxt" > {{ trans('words.First') }}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fname"  value="{{ old('fname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.Last') }}</label>
							<div class="col-md-6">
 							<input type="text" class="form-control" name="lname" value="{{ old('lname') }}"> 							</div>
						</div>




						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.Email') }}</label>
							<div class="col-md-6">
 								<input type="email" class="form-control" name="email" value="{{ old('email') }}"> 							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.Password') }}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.confirm') }}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.phone') }}</label>
							<div class="col-md-6">
 								<input type="text" class="form-control" name="phone" value="{{ old('phone') }}"> 							</div>
						</div>


						<div class="form-group">
							<label class="col-md-4 control-label navtxt">{{ trans('words.Location') }}</label>
							<div class="col-md-6">
 								<input type="text" class="form-control" name="location" value="{{ old('location') }}"> 							</div>
						</div>


						<div class="form-group">
     						<label class="col-md-4 control-label navtxt">{{ trans('words.Type') }}</label>
							<div class="col-md-4">
						        <select   class="form-control" name="type">
							        <option value="regular"
									@if(old('type')==="regular") {{"selected=true"}} @endif >{{ trans('words.regular') }}</option>
							        <option value="tech"
							        @if(old('type') ==="tech") {{"selected=true"}} @endif >{{ trans('words.tech') }}</option>
							        <option value="admin"
							        @if(old('type') ==="admin") {{"selected=true"}} @endif >{{ trans('words.admin') }}</option>
							    </select>
						    </div>
					    </div>

						 <div class="form-group">
     						<label class="col-md-4 control-label navtxt">{{ trans('words.Disable') }}</label>
								<div class="col-md-6">
							        @if (old('isspam') == 0)
							            {!! Form::checkbox('isspam', 'value') !!}
							        @else
							            {!! Form::checkbox('isspam', 'value',true) !!}
							        @endif

  						        </div>
					    </div>

			
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn navbtn txtnav">
									Add user
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
$(document).ready(function(){


	if ("<?php echo Lang::getLocale();  ?>"  == "ar" ){
		$(".control-label").css({
        
        float: 'right' ,
        
    });

		$("#header").css({
        //display:'block',
        float: 'right' ,
    });

		$(".alert alert-danger").css({

			//text-align:'right', 
			float:'right',

		});
		

	}

	});

</script>
@endsection
