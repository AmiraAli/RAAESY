
/**
* function to get search by date
**/
function searchDate () {

		var startdate=document.getElementById("startdate").value;
		var enddate=document.getElementById("enddate").value;
		if( startdate != "" && enddate != ""){
				$.ajax({
				      url: '/reports/problemMangementDate',
				      type: "post",
				      data: {'startdate':startdate, 'enddate':enddate},
				      success: function(data){
				       $("#container").html(data)
										       
						// ----------------------------------------
						        $('#startdate').datetimepicker({
						            format:'Y-m-d H:00:00',
						        });
						        $('#enddate').datetimepicker({
						            format:'Y-m-d H:00:00',
						        });
						//-----------------------------------------

				      },
					  error: function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					  }
				    });



			}
}


