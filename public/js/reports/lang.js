

window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };
 
function language(){
var startdate=document.getElementById("startdate").value;
		var enddate=document.getElementById("enddate").value;
    var lang=$("#lang").text();
console.log(lang);
    $.ajax({
            
            url: '/reports/problemmangementlang',
            type: 'post',
            data: {lang:lang,'startdate':startdate, 'enddate':enddate},
            success: function(result) {
if (lang=="English")
 $("#lang").text("عربى");
else
 $("#lang").text("English");
$("#container").html(result);



                //ticketsStatistics(result["createdTickets"],result["closedTickets"], result["points"]);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}
