

$('#searchticket').keyup(function(){var x=$('#searchticket').val(); 

$.ajax({
    url: '/subjects/all/',
    type: 'post',


    success: function(result) {
		subjects=JSON.parse(result);

		 var availableTags =subjects;
		 $( "#searchticket" ).autocomplete({
		      source: availableTags
		});
	},
	error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.error);
    }
});
});







   
