//alert('yarab far7a');

window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };


function Delete(elm){


  //var ids = elm.name.split("_");

//ajax request
   $.ajax({
    url: '/articles/'+elm,
    type: 'DELETE',
    success: function(result) {
		$('#'+elm).remove(); 
		//alert('yarab far7a');   
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(errorThrown);
    }
});

}
