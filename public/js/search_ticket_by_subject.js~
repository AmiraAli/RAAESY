window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function SearchButton(){

console.log("aya");

  var subjectOfTicket = $('#searchticket').val();
  console.log(subjectOfTicket);
                  
$.ajax({
    url: '/tickets/all/subjects',
    type: 'post',
    data: { name: subjectOfTicket },

    success: function(result) {

	//console.log(JSON.parse(result)[0].id);
console.log(result);
$("#table_show").html(result);
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
   

}
