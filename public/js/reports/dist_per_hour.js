window.onload = function () {

var hours = [];
var data = [];
for (var i = 0 ; i<24 ; i++){
     hours.push(i+":00");
     data.push(i);
}

console.log (document.getElementById("defaultdata").value);
console.log();



    $('#container').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: 'Area chart with negative values'
        },
        xAxis: {
            categories: hours
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '12:00',
            data: [1 , 2 ]
        }, {
            name: '1:00',
            data: data
        }

        ]
    });
};

