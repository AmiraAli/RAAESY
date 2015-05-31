 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function AdvancedSearch(){
  var priority =document.getElementById("ticketPriority").value;
  var StartDate =document.getElementById("ticketStartDate").value;
   var endDate =document.getElementById('ticketEndDate').value;
  var TechnicalSelect =document.getElementById("ticketTechnical");               
var options = TechnicalSelect.options;
var id      = options[options.selectedIndex].id.split(",")[0];
var value      = options[options.selectedIndex].value;
   console.log(priority);
console.log(StartDate);
  console.log(endDate);
console.log(id);

console.log(value);
$.ajax({
    url: '/tickets/advancedsearch',
    type: 'post',
data:{tech_id:id,priority:priority,created_at:StartDate,enddate:endDate},

    success: function(result) {
console.log(result);
$("#table_show").html(result);
		
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});

}
