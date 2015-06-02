@extends('app')

<!DOCTYPE html>
<html>
<head>
	<script sync src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script sync src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script sync src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script sync src="http://code.highcharts.com/highcharts.js"></script>
<script sync src="http://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
@section('content')

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@stop

<script sync src="/js/reports/dist_per_hour.js"></script>


</body>
</html>






