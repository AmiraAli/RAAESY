
/**
* popup settings  
**/
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
    	html:true,
    	placement: 'left'
    });   
});

/**
* functions of ajaxs tickets
**/
window.onload = function() {
                    $.ajaxSetup({
					                headers: {
					                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
					                }
            					});
            				};

 /**
 * delete function
 **/
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

/**
*spam function
**/
function spam(id){
//ajax request
$.ajax({
		url: '/tickets/spamTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
			document.getElementById(id).remove();    
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}