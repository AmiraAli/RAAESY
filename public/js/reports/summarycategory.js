
var classes=document.getElementsByClassName("category");
var countes=document.getElementsByClassName("count");

array=[];
if (classes)
{array[0]=['Task', 'Hours per Day'];}
for(i=0;i<classes.length;i++){

array[i+1]=[classes[i].value,parseInt(countes[i].value)];

}
length=array.length;





    google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
drawChart();
      function drawChart() {

        var data = google.visualization.arrayToDataTable(array);

        var options = {
          title: 'Tickets Per Category',
	
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
