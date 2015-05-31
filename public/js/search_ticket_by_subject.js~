window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function SearchButton()(){
  var subjectOfTicket = $('#searchticket').val();
  
                  
$.ajax({
    url: '/tickets/all/subjects',
    type: 'post',
    data: { name: subjectOfTicket },

    success: function(result) {
	

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
   

}
