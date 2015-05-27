window.onload = function() {
                    $.ajaxSetup({
					                headers: {
					                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
					                }
            					});
            				};
function Delete(id){
//ajax request
   $.ajax({
    url: '/tickets/'+id,
    type: 'DELETE',
    success: function(result) {
		document.getElementById(id).remove();    
	},
	error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
    }
});

}