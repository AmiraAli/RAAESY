@extends('app')





<!-- <script   src="/js/reports/dist_per_hour.js"></script> -->


@section('content')




<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<input type="hidden" id="defaultdata" value ="{{var_dump ($tickets) }}">

<script   src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script  src="http://code.highcharts.com/highcharts.js"></script>
<script  src="http://code.highcharts.com/modules/exporting.js"></script>
<script  src="/js/reports/dist_per_hour.js"></script>





@endsection







