<html>
<body>
@foreach($ticketsPerCategories as $ticketsPerCategorie)
<input type="hidden" class="category" value="{{$ticketsPerCategorie->category->section->name}}/{{$ticketsPerCategorie->category->name}}">
<input type="hidden" class="count" value={{$ticketsPerCategorie->tg}}>
@endforeach
<div id="summarycategory" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>




 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="/js/jquery-2.1.3.js" type="text/javascript"> </script> 
 <script async src="//code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
 <script type="text/javascript" src="/js/reports/summarycategory.js"></script>

</body>
</html>
