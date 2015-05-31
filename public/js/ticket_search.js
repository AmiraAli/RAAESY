function searchTicket (arr, id) {

	console.log( (arr[0]) );
	$("#icons_list").find(".active").removeClass("active");
	$("#"+id).addClass("active");
	// $("#tbodyid").empty();

	var searchData = {
            'name'  : id
        };

	$.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);

		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});



}
