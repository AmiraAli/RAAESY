$(function () {
var classes=document.getElementsByClassName("category");
var countes=document.getElementsByClassName("count");
console.log(typeof(parseInt(countes[0].value)));
array=[];
for(i=0;i<classes.length;i++){
array[i]=[classes[i].value,parseInt(countes[i].value)];

}
console.log(classes);
    $('#summarycategory').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidtsh: null,
            plotShadow: false
        },
        title: {
            text: 'Tickets per Categories'
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
            name: 'Tickets section/category',
            data: array

                 
              
            
        }]
    });
});

