
@extends('app')
@section('content')
    
<script src="/js/DeleteUser.js"></script>
<script src="/js/users/index.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script src="/js/users/toggleSearch.js"></script>
<link rel="stylesheet" type="text/css" href="/css/users/index.css">
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />



<div class="container">
	<br>
	<div class="row">
		<div id="search">
	        <div class="form-group">
	            <label class="col-md-5 control-label navtxt"><b>Quick Search</b></label>
	            <div class="col-md-7"> 
	                <input type="text" class="form-control parent" placeholder="Fname/Lname/Email" onkeyup="myAutocomplete(this.value)" name="term" id="quickSearch"  autocomplete="on">
	            	<div id="autocompletemenu" style="display: none;">
					   <ul id="autocompleteul"></ul>
					</div>
	            </div>
	        </div>
	    </div>
	

		<div id="new-user">
			 <a id="csv" href="users/downloadCSV">
                <img src="/images/CSV.png" style="width:40px"></img>
            </a>
			<a class="btn btn-primary" href="/users/create" >Create User</a>
		</div>
	</div>

	<div class="row">
        <div class="form-group">
            <label class="col-md-1 control-label navtxt sho"><b>Show</b></label>
            <div class="col-md-6"> 
                <label class="sho"><input type="radio" name="user" value="all"   onclick="search()" checked="true"> All</label> |
				<label class="sho"><input type="radio" name="user" value="regular"   onclick="search()">  Regular Users</label> | 
				<label class="sho"><input type="radio" name="user" value="tech"  onclick="search()">  Technicians</label> |
				<label class="sho"><input type="radio" name="user" value="admin"  onclick="search()">  Admins </label>|
				<label class="sho"><input type="radio" name="user" value="disabled"  onclick="search()">  Disabled users </label>

            </div>
        </div>
        <button id="toggle" class="btn btn-primary" > <span class="glyphicon glyphicon-search"></span></button>
    </div>
	
	<!-- <a id="pdf" href="users/downloadPDF" ><img src="/images/CSV.png"></a> -->
	
	</br>
	<div class="row">
		<div  id="con" class="col-md-12" >
			<table class="table table-hover">
				<thead>
					<tr class="navbtn txtnav">
						<th class="text-center">Name</th>
						<th class="text-center">Email</th>
						<th class="text-center">Phone</th>
						<th class="text-center">Location</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody id="tbody">
					@foreach($users as $user)
						<tr id="{{$user->id}}">
							<td class="text-center"><a href="/users/{{$user->id}}"><b>{{$user->fname}}	{{$user->lname}}</b></a></td>
							<td class="text-center">{{$user->email}}</td>
							<td class="text-center">{{$user->phone}}</td>
							<td class="text-center">{{$user->location}}</td>      
							<td class="text-center">
								@if ($user->id != "1")
									<a href="#" class="transparent disable" onclick="Spam('disable_{{$user->id}}')" ><img src="/images/disable.png" width="30px" height="30px"></a>
									&ensp;&ensp; &ensp;
								@endif
								@if ($user->id != "1" | ($user->id == "1" && $current_user->id == "1" ) )
									<a href="/users/{{$user->id}}/edit" class="do"><img src="/images/edit.png" width="30px" height="30px">   </a> 
								@endif

								@if ($user->id != "1")
									 &ensp;&ensp; &ensp;
								 	<a href="#" id="{{$user->id}}" onclick="Delete({{$user->id}})"><img src="/images/delete.png" width="30px" height="30px"></a>
								@endif
							</td>

						</tr>
					@endforeach
				</tbody>
			</table>
			<?php echo $users->render(); ?>
		</div>


		<div class="col-md-3" id="advancedSearchDiv">
			<div class="row">
				<div class="panel">
					<div class="panel-heading navbtn txtnav">
						<h3 class="panel-title">Advanced Search</h3>
					</div>
					<div class="panel-body">
						<form class= "form-horizontal" onsubmit="return false" id="advSearchForm">					
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 

							<div class="form-group">
								<label class="col-md-3 control-label navtxt">FName</label>
								<div class="col-md-6">
									<input type="text" id="fname" class="form-control" name="fname" value="{{ old('email') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label navtxt">LName</label>
								<div class="col-md-6">
									<input type="text" id="lname" class="form-control" name="lname" value="{{ old('email') }}">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label navtxt">E-Mail</label>
								<div class="col-md-6">
									<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label navtxt">Phone</label>
								<div class="col-md-6">
									<input type="text" id="phone" class="form-control" name="phone">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label navtxt">Location</label>
								<div class="col-md-6">
									<input type="text" id="location" class="form-control" name="location">
								</div>
							</div>

							<input type="hidden" id="displayed" name="displayed">

							<div class="form-group">
								<div class="col-md-3 col-md-offset-2">
									<button type="submit" onclick="search()" class="btn navbtn txtnav">Search</button>
								</div>
								<div class="col-md-3">
									<button type="reset" class="btn navbtn txtnav">Reset</button>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection




