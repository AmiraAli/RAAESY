 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function Delete(elm){


  var ids = elm;

//ajax request
   $.ajax({
    url: '/users/'+ids,
    type: 'DELETE',
    success: function(result) {
		$('#'+ids).remove();    
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(errorThrown);
    }
});

}
