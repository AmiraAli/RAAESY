window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };

function searchByCat (id) {
	$("#category_list").find(".active").removeClass("active");
	$("#"+id).addClass("active");
    cat_sec = id.split("_");   
    var searchData = {}; 
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
	    url: '/home/searchArticle',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#article-show').html(result);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});
}