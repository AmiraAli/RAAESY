window.onload = function() {
                    $.ajaxSetup({
					                headers: {
					                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
					                         }
            					  });
            				 };
/**
* function to get search by date
**/
function search () {
	var date=document.getElementById("date").value;
	if( date != "custom"){
		$.ajax({
			      url: '/reports/summarySearchDate',
			      type: "post",
			      data: {'date':date},
			      success: function(data){

			       $("#container").html(data);
			      paginateWithAjax();

			      },
				  error: function(jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				  }
			    });
	}else{
		var startdate=document.getElementById("startdate").value;
		var enddate=document.getElementById("enddate").value;
		if( startdate != "" && enddate != ""){
			$.ajax({
				      url: '/reports/summarySearchDate',
				      type: "post",
				      data: {'startdate':startdate, 'enddate':enddate, 'date':date},
				      success: function(data){
				       $("#container").html(data)
				       document.getElementById("customedate").style.display="block";

				        paginateWithAjax();

				      },
					  error: function(jqXHR, textStatus, errorThrown) {
						alert(errorThrown);
					  }
				    });
	}

	}

}

function custom () {
	var date=document.getElementById("date").value;
	if( date == "custom"){
			document.getElementById("customedate").style.display="block";
		}else{
					document.getElementById("customedate").style.display="none";

		}
}
