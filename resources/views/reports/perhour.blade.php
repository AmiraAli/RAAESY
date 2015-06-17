@extends('app')
@section('content')

<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
<link rel="stylesheet" type="text/css" href="/css/reports/perhour.css">
<div class="container">
	<h3 class="navtxt"><a href="{{ url('/reports')}}"> Reports</a>
	>>Tickets per Hour</h3>
</div>
<div class="container">
<br>
<div class="row">

<form  class="form-inline" onsubmit="getReport(); return false;" >
  <div class="form-group col-md-3">
    <label>From</label>
    <input type="text" class="form-control" id="date1" value="<?php echo date('Y-m-d H:i:s', strtotime('-10day')) ?>">
  </div>
  <div class="form-group col-md-3">
    <label>To</label>
    <input type="text" class="form-control" id="date2" value="<?php echo date('Y-m-d H:i:s', time()) ?>">
  </div>
  <div class="form-group col-md-3">
    <button class="btn navbtn txtnav hv" >Get Report</button>
  </div>
</form >
</div>
<br><br><br>
<div  class="row divchart" id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	<input type="hidden" id="defaultOpen" value ="{{ $defaultOpen }}">
	<input type="hidden" id="defaultClose" value ="{{ $defaultClose }}">

 </div>

<script   src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script  src="http://code.highcharts.com/highcharts.js"></script>
<script  src="http://code.highcharts.com/modules/exporting.js"></script>
<script  src="/js/reports/dist_per_hour.js"></script>


<link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
<script src="/datetimepicker/jquery.datetimepicker.js"></script>

<script >
	$(document).ready(function() {

    $('#date1').datetimepicker({
  		 format:'Y-m-d H:i:s',
       mask:true, // '9999/19/39 29:59' - digit is the maximum possible for a cell
    });
    $('#date2').datetimepicker({
  		 format:'Y-m-d H:i:s',
       mask:true, // '9999/19/39 29:59' - digit is the maximum possible for a cell
    });

 });
</script>




@endsection







