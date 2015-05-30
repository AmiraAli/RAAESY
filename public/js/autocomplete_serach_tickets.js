
$(function() {
$('#searchticket').keyup(function(){var x=$('#searchticket').val(); 

$.ajax({
    url: '/subjects/all/',
    type: 'post',


    success: function(result) {
console.log("aya");
subjects=JSON.parse(result);
console.log(subjects);

 var availableTags =subjects;
 $( "#searchticket" ).autocomplete({
      source: availableTags
});
},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
});


});




   
