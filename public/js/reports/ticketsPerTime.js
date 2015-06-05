

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
            dataType: "json",
            url: '/reports/prepareTickets',
            type: 'post',
            data: formData,
            success: function(result) {
                ticketsStatistics(result["createdTickets"],result["closedTickets"], result["points"]);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}
