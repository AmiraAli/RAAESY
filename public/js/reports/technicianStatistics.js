window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };
           
function technicianStatisticsSearch() 
{

    var searchData = {
            'from'  : $('#from').val() ,
            'to'    : $('#to').val()
        };
		
    $.ajax({
	    url: '/reports/technicianStatisticsSearch',
    	type: 'post',
    	data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);
			 
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});	
}