 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
 }


function recaptcha(){
	
	//ajax request
   $.ajax({
    url: '/auth/recaptcha',
    type: 'GET',
    data: {  
   	name: name
   	    },
    success: function(result) {
		$("#captcha").html(result)
					},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}