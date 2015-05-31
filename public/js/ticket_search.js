

function searchTicket (id) {
	$("#icons_list").find(".active").removeClass("active");
	$("#"+id).addClass("active");
	// $("#tbodyid").empty();
	cat_sec = $("#category_list").find(".active").attr('id').split("_");

	var searchData = {
            'name'  : id
        };
    if(cat_sec[0] == "cat"){
    	searchData["cat"] = cat_sec[1];
    }
    if(cat_sec[0] == "sec"){
    	searchData["sec"] = cat_sec[1];
    }

    searchAjax(searchData);	
}

function searchAjax(searchData){
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

function searchByCat (id) {
	$("#category_list").find(".active").removeClass("active");
	$("#"+id).addClass("active");
	var name = $("#icons_list").find(".active").attr('id');
	var searchData = {
            'name'  : name
        };
    cat_sec = id.split("_");    
    if(cat_sec[0] == "cat"){
    	searchData["cat"] = cat_sec[1];
    }
    if(cat_sec[0] == "sec"){
    	searchData["sec"] = cat_sec[1];
    }
    console.log(searchData);
    searchAjax(searchData);	
}

