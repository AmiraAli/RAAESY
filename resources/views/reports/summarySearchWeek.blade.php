<div class="row">
		<div class="col-md-3">
			<select class="form-control" id="date" onchange="custom()">
				<option value="month">Last month</option>
		  		<option value="week" selected="true">Last week</option>
                <option value="custom">Custom</option>

			</select>
		</div>
        <div class="col-md-5" style="display:none;" id="customedate">
            From:<input type="text" id="startdate">
            To:<input type="text" id="enddate">
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
    <div class="row">
        <table class="table table-condensed">
            <tr>
            <td > Ticket ID</td>
            <td> Ticket Subject</td>
            <td> Ticket Category</td>
            <td> Assigned To</td>
            <td> Start Date</td>
            <td> Close Date</td>
            <td> Deadline </td>
            <td> Status </td>
            <td> Priority</td>
            </tr>
            @foreach($tickets as $ticket)
            <tr>
                <td>#{{ $ticket->id }}</td>
                <td> {{ $ticket->subject->name }} </td>
                <td> {{ $ticket->category->section->name }}/{{ $ticket->category->name }}</td>

                @if($ticket->tech_id != NULL)
                    <td> {{ $ticket->tech->fname }}</td>
                @else
                    <td></td>
                @endif

                <td> {{ $ticket->created_at }} </td>

                @if($ticket->status == "close")
                    <td> {{ $ticket->updated_at }} </td>
                @else
                    <td></td>
                @endif

                <td>{{ $ticket->deadline }} </td>
                <td> {{ $ticket->status }} </td>

                @if($ticket->priority == "low")
                    <td><b class="alert-success ">{{ $ticket->priority }}</b></td>
                @elseif($ticket->priority == "high")
                    <td><b class="alert-warning">{{ $ticket->priority }}</b></td>
                @else
                    <td><b class="alert-danger">{{ $ticket->priority }}</b></td>
                @endif
            </tr>
            @endforeach
        </table>
 </div>
 <script type="text/javascript" src="/js/reports/summarycategory.js"></script>	
 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>


<script type="text/javascript" >
var Globals = <?php echo json_encode(array(
											    'inprogressCount' => $inprogressCount,
											    'newCount'=>$newCount,
											    'resolvedCount'=>$resolvedCount
											)); ?>;

$(document).ready(function() {

    $('#startdate').datetimepicker({
        format:'Y-m-d H:00:00',
          });
    $('#enddate').datetimepicker({
        format:'Y-m-d H:00:00',
          });

 });

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

