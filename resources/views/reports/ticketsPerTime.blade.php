@extends('app')


@section('content')
    <script sync src="http://code.jquery.com/jquery-1.9.0.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />
        <div class="container-fluid">
        <div class="row">
         <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading"> <strong>Tickets per day</strong> </div>
                <div class="panel-body">
                        <div class="form-group col-md-3">
                            <label class="col-md-2 control-label">From</label>
                            <input type="text" name="from" class="form-control" value="<?php echo date('Y-m-d', strtotime('-2 day')) ?>" id="from" />
                        </div>

                        <div class="form-group col-md-3">
                            <label class="col-md-2 control-label">To</label>
                            <input type="text" name="deadline" class="form-control" value="<?php echo date('Y-m-d', strtotime('+0 day')) ?>" id="to"/>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="col-md-4 control-label">Group by</label>
                            <select class="form-control" name="groupby" id="groupby">                      
                                <option value="day" >Day</option>
                                <option value="month" >Month</option>
                                <option value="week" >Week</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary " onclick="prepareTickets ()">Go</button>

                            <a  href="{{ url('/assets/csvimport') }}"><img src="/images/CSV.png" style="width:40px"></a>

                        </div>
                </div>
                </div>
            </div>
            </div>
        </div>




    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script src="/js/reports/ticketsPerTime.js"></script>

    <script>
        var createdTickets = <?php echo '[' . implode(', ', $createdTickets) . ']' ?>;
        var closedTickets = <?php echo '[' . implode(', ', $closedTickets) . ']' ?>;
        var points = <?php echo '["' . implode('", "', $points) . '"]' ?>;
        console.log(closedTickets);
        ticketsStatistics(createdTickets, closedTickets, points);

        var unit = $("#groupby").val();


        function ticketsStatistics(createdTickets,closedTickets, points){
            $(function () {
                $('#container').highcharts({
                    chart: {
                        type: 'area'
                    },
                    title: {
                        text: 'Tickets per '+unit
                    },
                    xAxis: {
                        categories: points,
                        tickmarkPlacement: 'on',
                        title: {
                            enabled: false
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Tickets'
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        valueSuffix: ' Tickets'
                    },
                    plotOptions: {
                        area: {
                            //stacking: 'normal',
                            lineColor: '#666666',
                            lineWidth: 1,
                            marker: {
                                lineWidth: 1,
                                lineColor: '#666666'
                            }
                        }
                    },
                    series: [{
                        name: 'Tickets created',
                        data: createdTickets
                    },{
                        name: 'Tickets closed',
                        data: closedTickets
                    }]
                });
            });
        }

    </script>


 <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
 <script src="/datetimepicker/jquery.datetimepicker.js"></script>

 <script >
    $(document).ready(function() {

        $('#from').datetimepicker({
            format:'Y-m-d H:00:00',
              });
        $('#to').datetimepicker({
            format:'Y-m-d H:00:00',
              });

 });
 </script>
@endsection