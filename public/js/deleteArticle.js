
function Delete(elm){


    //ajax request
   $.ajax({
    url: '/articles/'+elm,
    type: 'DELETE',
    success: function(result) {
		$('#'+elm).remove(); 
	},
	error: function(jqXHR, textStatus, errorThrown) {
    
                    console.log(errorThrown);
    }
});

}
