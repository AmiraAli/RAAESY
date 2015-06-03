@extends('app')


@section('content')
    <script sync src="http://code.jquery.com/jquery-1.9.0.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

        <div class="col-md-12 ">
            <div class="panel panel-success">
                <div class="panel-heading">Search</div>
                <div class="panel-body">
      

                    
                    <form class= "form-horizontal" onsubmit="return false">                 
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group search">
                                <label class="col-md-4 control-label">From</label>
                                <div class="col-md-2">
                                    <input type="date" name="from" class="form-control" id="from" value="<?php echo date('Y-m-d', strtotime('-2 day')) ?>" />
                                </div>
                            </div>

                            <div class="form-group search">
                                <label class="col-md-4 control-label">To</label>
                                <div class="col-md-2">
                                    <input type="date" name="to" class="form-control" id="to" value="<?php echo date('Y-m-d', strtotime('+0 day')) ?>" />
                                </div>
                            </div>

                             <div class="form-group search">
                                <label class="col-md-1 control-label">Group by</label>
                                <div class="col-md-1">
                                    <select class="form-control" name="groupby" id="groupby">                      
                                        <option value="day" >Day</option>
                                        <option value="month" >Month</option>
                                        <option value="week" >Week</option>
                                    </select>
                                </div>
                             </div>

                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" onclick="prepareTickets()" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>




    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script src="/js/reports/ticketsPerTime.js"></script>

    <script>
        var createdTickets = <?php echo '[' . implode(', ', $createdTickets) . ']' ?>;
        var points = <?php echo '["' . implode('", "', $points) . '"]' ?>;

        ticketsStatistics(createdTickets, points);

        var unit = $("#groupby").val();


        function ticketsStatistics(createdTickets, points){
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
                            text: 'Billions'
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        valueSuffix: ' millions'
                    },
                    plotOptions: {
                        area: {
                            stacking: 'normal',
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
                    }]
                });
            });
        }

    </script>
@endsection