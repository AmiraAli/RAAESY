 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function Status(elm){


  var ticket_id = elm;

     var status =document.getElementById(elm).name;
                  console.log(status);
$.ajax({
    url: '/tickets/updatestatus/',
    type: 'post',
    data: { ticket_id: ticket_id,status:status },

    success: function(result) {

		if($('#'+ticket_id).text()=='closed'){

		$('#'+ticket_id).text('reopen');
		$('#'+ticket_id).attr('name','open');}
		else{

		$('#'+ticket_id).text('closed');
		$('#'+ticket_id).attr('name','close');

			}

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(errorThrown+textStatus+jqXHR);
    }
});
   

}
