<html>
<head>

     
	

        
</head>
<body>
<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
@extends('app')
@section('content')


<div class="container">

<div  id="con" class="col-md-12" >
@foreach($logs as $log)

{{$log->id}}
@endforeach


</div>



		</div>
			</div>
				</div>				
</div>



@stop

</body>
</html>
