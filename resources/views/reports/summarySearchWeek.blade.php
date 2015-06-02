<div class="row">
		<div class="col-md-3">
			<select class="form-control" id="date" onchange="custom()">
				<option value="month">Last month</option>
		  		<option value="week" selected="true">Last week</option>
                <option value="custom">Custom</option>

			</select>
		</div>
        <div class="col-md-5" style="display:none;" id="customedate">
            From:<input type="date" id="startdate">
            To:<input type="date" id="enddate">
        </div>
		<div style="float:left;">
			<button class="btn btn-primary" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			@foreach($ticketsPerCategories as $ticketsPerCategorie)
				<input type="hidden" class="category" value="{{$ticketsPerCategorie->category->section->name}}/{{$ticketsPerCategorie->category->name}}">
				<input type="hidden" class="count" value="{{ $ticketsPerCategorie->count }}">
			@endforeach
			<div id="summarycategory" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
		</div>
		<div class="col-md-6">
			<div id="status" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
		</div>
	</div>
 <script type="text/javascript" src="/js/reports/summarycategory.js"></script>	
<script type="text/javascript" >
var Globals = <?php echo json_encode(array(
											    'inprogressCount' => $inprogressCount,
											    'newCount'=>$newCount,
											    'resolvedCount'=>$resolvedCount
											)); ?>;
$(function () {
    $('#status').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Tickets Status'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Tickets Status',
            data: [
                ['Inprogress',  Globals.inprogressCount],
                ['New',      Globals.newCount],
                ['Resolved',   Globals.resolvedCount]          
                  ]
        }]
    });
});


</script>
 <script type="text/javascript" src="/js/reports/summarysearch.js"></script>

