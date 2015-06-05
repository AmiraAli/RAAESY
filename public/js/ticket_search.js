window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
                    
            };
            
$( "#selectFields" ).click(function() {
  $( '#check' ).slideToggle( "fast" );
});


  $('.checkbox1').change(function() {
        if(!$(this).is(":checked")) 
        {
            $('.'+$(this).val()).hide();
        }
        else
        {
        	$('.'+$(this).val()).show();
        }
    });

function tag() 
{
		var name = $("#icons_list").find(".active").attr('id');
		var searchData = {
            'name'  : name
        };

		cat_sec = $("#category_list").find(".active").attr('id').split("_");

	    if(cat_sec[0] == "cat"){
	    	searchData["cat"] = cat_sec[1];
	    }
	    if(cat_sec[0] == "sec"){
	    	searchData["sec"] = cat_sec[1];
	    }

     if ($("#sortType").text() == "DESC")
			 {
			 	searchData["sortType"] = "DESC";
			 } 
			 else
			 {
			 	searchData["sortType"] = "ASC";
			 }
    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();

	    $.ajax({
		    url: '/tickets/searchTicket',
	    	type: 'post',
	    	data: searchData,
		    success: function(result) {
				 $('#table_show').html(result);
				 $('.checkbox1').each(function () {
					 if(!$(this).is(":checked")) 
				        {
				        	
				            $('.'+$(this).val()).hide();

				        }
				        else
				        {
				        
				        	$('.'+$(this).val()).show();
				        }
				    
				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
		    }
		});	
}

function sortBy() 
{

	var name = $("#icons_list").find(".active").attr('id');
	var searchData = {
            'name'  : name
        };

	cat_sec = $("#category_list").find(".active").attr('id').split("_");

    if(cat_sec[0] == "cat"){
    	searchData["cat"] = cat_sec[1];
    }
    if(cat_sec[0] == "sec"){
    	searchData["sec"] = cat_sec[1];
    }
    searchData["sortType"] = "DESC";
    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();
    
    $.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);
			 $("#sortType").html("DESC");

			$('.checkbox1').each(function () {
				 if(!$(this).is(":checked")) 
			        {
			        	
			            $('.'+$(this).val()).hide();

			        }
			        else
			        {
			        
			        	$('.'+$(this).val()).show();
			        }
			    
			});
			tag();
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});			
}

function sortType(){
	var name = $("#icons_list").find(".active").attr('id');
	var searchData = {
            'name'  : name
        };

	cat_sec = $("#category_list").find(".active").attr('id').split("_");

    if(cat_sec[0] == "cat"){
    	searchData["cat"] = cat_sec[1];
    }
    if(cat_sec[0] == "sec"){
    	searchData["sec"] = cat_sec[1];
    }

    if ($("#sortType").text() == "DESC")
			 {
			 	searchData["sortType"]="ASC";
			 } 
			 else
			 {
			 	searchData["sortType"]="DESC";
			 };
    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();

   $.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);

			 if ($("#sortType").text() == "DESC")
			 {
			 	$("#sortType").html("ASC");
			 } 
			 else
			 {
			 	$("#sortType").html("DESC")
			 };
			 $('.checkbox1').each(function () {
			 if(!$(this).is(":checked")) 
		     {
		        	
		       $('.'+$(this).val()).hide();

		     }
		     else
		     {
		        
		        $('.'+$(this).val()).show();
		     }
    
});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});
    
}

function searchTicket (id) {
	$("#icons_list").find(".active").removeClass("active");
	$("#"+id).addClass("active");
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
     if ($("#sortType").text() == "DESC")
			 {
			 	searchData["sortType"] = "DESC";
			 } 
			 else
			 {
			 	searchData["sortType"] = "ASC";
			 }
    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();


    searchAjax(searchData);	
}



function searchAjax(searchData){
	   $.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);


			 $('.checkbox1').each(function () {
			 if(!$(this).is(":checked")) 
		     {
		        	
		       $('.'+$(this).val()).hide();

		     }
		     else
		     {
		        
		        $('.'+$(this).val()).show();
		     }
    
			});
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
     if ($("#sortType").text() == "DESC")
			 {
			 	searchData["sortType"] = "DESC";
			 } 
			 else
			 {
			 	searchData["sortType"] = "ASC";
			 }
    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();

    searchAjax(searchData);	
}

