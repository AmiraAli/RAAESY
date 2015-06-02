// var points = ['1750', '1800', '1850', '1900', '1950', '1999', '3000'];
// var unit = $("#groupby").val();
// var from = $("#from").val();
// var to = $("#to").val();

// if(unit == "day"){
//     alert()
// }else if(unit == "week"){

// }else if(unit == "month"){

// }
// var createdTickets = [502, 635, 809, 947, 1402, 3634, 400];
// var closedTickets = [18, 31, 54, 156, 339, 818, 1201];

window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };
 
function prepareTickets(){
    var formData = {
                'unit': $("#groupby").val(),
                'from': $("#from").val(),
                'to' : $("#to").val()
            }; 

    $.ajax({
            url: '/reports/prepareTickets',
            type: 'post',
            data: {'unit': "aaaaaaaaaaaaaaaaaa"},
            success: function(result) {
                console.log(result);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}

// $(function () {
//     $('#container').highcharts({
//         chart: {
//             type: 'area'
//         },
//         title: {
//             text: 'Tickets per '+unit
//         },
//         xAxis: {
//             categories: points,
//             tickmarkPlacement: 'on',
//             title: {
//                 enabled: false
//             }
//         },
//         yAxis: {
//             title: {
//                 text: 'Billions'
//             },
//             labels: {
//                 formatter: function () {
//                     return this.value / 1000;
//                 }
//             }
//         },
//         tooltip: {
//             shared: true,
//             valueSuffix: ' millions'
//         },
//         plotOptions: {
//             area: {
//                 stacking: 'normal',
//                 lineColor: '#666666',
//                 lineWidth: 1,
//                 marker: {
//                     lineWidth: 1,
//                     lineColor: '#666666'
//                 }
//             }
//         },
//         series: [{
//             name: 'Tickets created',
//             data: createdTickets
//         },{
//             name: 'Tickets closed',
//             data: closedTickets
//         }]
//     });
// });