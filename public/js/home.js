window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            paginateWithAjax();     
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

    searchAjax(searchData , "/home/searchArticle");	
}

function searchAjax(searchData , url){
    //alert(searchData["cat"]);
	$.ajax({
	    url: url,
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#article-show').html(result);
              paginateWithAjax();
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});
}


function paginateWithAjax(){
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        cat_sec = $("#category_list").find(".active").attr('id').split("_");

        var searchData = {};
        if(cat_sec[0] == "cat"){
            searchData["cat"] = cat_sec[1];
        }
       // alert(name);
        

        var url = $(this).attr('href');
        url = url.replace("/home/?","/home/searchArticle/?");

        searchAjax(searchData,url); 
    });
        
}