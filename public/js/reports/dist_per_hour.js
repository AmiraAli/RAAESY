


var hours = [];
var dataOpen = [];
var dataClose = [];

for (var i = 0 ; i<24 ; i++){
     hours.push(i+":00");
     dataOpen.push(0);
     dataClose.push(0);
}

//opened tickets
var defaultOpen = document.getElementById("defaultOpen").value ; 
var defaultOpen = defaultOpen.split(":");

for (var i = 0 ; i<defaultOpen.length ; i++){
    rowData = defaultOpen[i];
    rowData = rowData.split("_");
    dataOpen[  rowData[0] ]  = Number (rowData[1]);
}


//closed tickets
var defaultClose = document.getElementById("defaultClose").value ;
var defaultClose = defaultClose.split(":");

for (var i = 0 ; i<defaultClose.length ; i++){
    rowData = defaultClose[i];
    rowData = rowData.split("_");
    dataClose[  rowData[0] ]  = Number (rowData[1]);
}



function setChart (){


    $('#container').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: 'Distribution of tickets/hour'
        },
        xAxis: {
            categories: hours
        },
        credits: {
            enabled: false
        },
        series: [ {
           name: 'opened',
           data: dataOpen
        },{    
            name: 'closed',
            data: dataClose
        }

        ]
    });
}
setChart();


    $.ajaxSetup({
        headers: {
            'X-XSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
           



function getReport(){

    var date1 = document.getElementById('date1').value;
    var date2 = document.getElementById('date2').value;
    
    if (date1.trim() == "" && date2.trim() == "") {
        return ;
    };

    st = new Date(date1);
    end = new Date(date2);
    if (st > end){
         return ;
    }


    date1=date1+" 00:00:00";
    date2 =date2+" 23:59:59";
    
    //ajax:

    $.ajax({
        url: '/reports/disthourajax',
        type: 'post',
        data:{
            date1: date1,
            date2: date2
        }, 
        success: function(result) {
            result=JSON.parse(result);
            for (var i = 0 ; i<24 ; i++){
                 dataOpen[i]=0;
                 dataClose[i]=0;
                }

            for (var i = 0 ; i<result['open'].length ; i++){
                rowData = result['open'][i];
                dataOpen[  rowData['hour'] ]  = Number (rowData['count']);
            }
            
            for (var i = 0 ; i<result['close'].length ; i++){
                rowData = result['close'][i];
                dataClose[  rowData['hour'] ]  = Number (rowData['count']);
            }
            setChart();
                 
        },
        error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
        }
});



}

