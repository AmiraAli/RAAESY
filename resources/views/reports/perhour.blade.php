@extends('app')


@section('content')

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />


<div class="container">
From : <input type="date" id="date1" >
To : <input type="date" id="date2" >
<button onclick="getReport()" >Get Report</button>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<input type="hidden" id="defaultOpen" value ="{{ $defaultOpen }}">
<input type="hidden" id="defaultClose" value ="{{ $defaultClose }}">

 </div>




<script   src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script  src="http://code.highcharts.com/highcharts.js"></script>
<script  src="http://code.highcharts.com/modules/exporting.js"></script>
<script  src="/js/reports/dist_per_hour.js"></script>





@endsection







