

window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };
 


document.getElementById("translation").onclick= function(e){
        e.preventDefault();
 
        var startdate=document.getElementById("startdate").value;
		var enddate=document.getElementById("enddate").value;
        var lang=$("#translation").text();
        console.log(lang);
        $.ajax({
            
            url: '/reports/problemmangementlang',
            type: 'post',
            data: {
                lang:lang,
                startdate:startdate,
                enddate:enddate
            },
            success: function(result) {
                if (lang=="E")
                    $("#translation").text("ع");
                else
                    $("#translation").text("E");
                $("#container").html(result);

            // ----------------------------------------
                    $('#startdate').datetimepicker({
                        format:'Y-m-d H:00:00',
                    });
                    $('#enddate').datetimepicker({
                        format:'Y-m-d H:00:00',
                  });
            //-----------------------------------------



                //ticketsStatistics(result["createdTickets"],result["closedTickets"], result["points"]);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}
