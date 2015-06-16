window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            //convert pagination to AJAX    
			paginateWithAjax();

                    
            };


//convert pagination to AJAX
function paginateWithAjax(){
  
    $('.pagination a').on('click', function(e){
        e.preventDefault();

        var isAdmin = $("#auth").val();
        //alert(isAdmin);
        var url = $(this).attr('href');
        paginate(isAdmin , url);
    });
}




            
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

        if(    !$(".subject").is(":visible") && !$(".status").is(":visible") && !$(".category").is(":visible")
        	&& !$(".created_at").is(":visible") && !$(".deadline").is(":visible") && !$(".priority").is(":visible") ){
        	$(".setting").hide();
        }else{
        	$(".setting").show();
        }
    });


function AdvancedSearch(){

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
     if ($("#sortType").text() == "DESC"){
	 	searchData["sortType"] = "DESC";
	 } 
	 else{
	 	searchData["sortType"] = "ASC";
	 }

    searchData["sortBy"] = $('#sortBy ').val();
    searchData["tagId"] = $('#tag').val();

	searchData["priority"] = $("#ticketPriority").val();
	searchData["StartDate"] = document.getElementById("ticketStartDate").value;
	searchData["endDate"] = document.getElementById('ticketEndDate').value;
	var TechnicalSelect =document.getElementById("ticketTechnical");               
	var options = TechnicalSelect.options;
	searchData["tech"] = options[options.selectedIndex].id.split(",")[0];

	searchAjax(searchData, '');
}

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
    searchData["priority"] = $("#ticketPriority").val();
    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
 	var TechnicalSelect =document.getElementById("ticketTechnical");               
	var options = TechnicalSelect.options;
	searchData["tech"] = options[options.selectedIndex].id.split(",")[0];

	    $.ajax({
		    url: '/tickets/searchTicket',
	    	type: 'post',
	    	data: searchData,
		    success: function(result) {
				 $('#table_show').html(result);

				 paginateWithAjax();
				 
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

function sortBy(is_admin) 
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
    if(is_admin == 1){
	    searchData["tagId"] = $('#tag').val();
	    searchData["priority"] = $("#ticketPriority").val();
	    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
	   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
	 	var TechnicalSelect =document.getElementById("ticketTechnical");               
		var options = TechnicalSelect.options;
		searchData["tech"] = options[options.selectedIndex].id.split(",")[0];
	}
    
    $.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);
			 paginateWithAjax();

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
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});			
}

function sortType(is_admin){
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
    if(is_admin == 1){
	    searchData["tagId"] = $('#tag').val();
	    searchData["priority"] = $("#ticketPriority").val();
	    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
	   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
	 	var TechnicalSelect =document.getElementById("ticketTechnical");               
		var options = TechnicalSelect.options;
		searchData["tech"] = options[options.selectedIndex].id.split(",")[0];
	}

   $.ajax({
	    url: '/tickets/searchTicket',
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);
			 paginateWithAjax();

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

function searchTicket (id , is_admin) {
	getCategories(id, is_admin);
	
}



function searchAjax(searchData , url){
	
		if (url == ""){
			url = "/tickets/searchTicket";
		}

	   $.ajax({
	    url: url,
	    type: 'post',
	    data: searchData,
	    success: function(result) {
			 $('#table_show').html(result);
			 paginateWithAjax();

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

function searchByCat (id, is_admin) {
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
    if(is_admin == 1){
	    searchData["tagId"] = $('#tag').val();
	    searchData["priority"] = $("#ticketPriority").val();
	    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
	   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
	 	var TechnicalSelect =document.getElementById("ticketTechnical");               
		var options = TechnicalSelect.options;
		searchData["tech"] = options[options.selectedIndex].id.split(",")[0];
	}

    searchAjax(searchData , '');	
}

function getCategories(key, is_admin){
	var search = {
            'key'  : key
        };
	   $.ajax({
	    url: '/tickets/getCategories',
	    type: 'post',
	    data: search,
	    success: function(result) {
			 $('#category_list').html(result);
			 $("#icons_list").find(".active").removeClass("active");
			$("#"+key).addClass("active");
			cat_sec = $("#category_list").find(".active").attr('id').split("_");

			var searchData = {
		            'name'  : key
		        };
		    if(cat_sec[0] == "cat"){
		    	searchData["cat"] = cat_sec[1];
		    }
		    if(cat_sec[0] == "sec"){
		    	searchData["sec"] = cat_sec[1];
		    }
		     if ($("#sortType").text() == "DESC"){
			 	searchData["sortType"] = "DESC";
			 } 
			 else{
			 	searchData["sortType"] = "ASC";
			 }


		    searchData["sortBy"] = $('#sortBy ').val();
		    if(is_admin == 1){
			    searchData["tagId"] = $('#tag').val();
			    searchData["priority"] = $("#ticketPriority").val();
			    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
			   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
			 	var TechnicalSelect =document.getElementById("ticketTechnical");               
				var options = TechnicalSelect.options;
				searchData["tech"] = options[options.selectedIndex].id.split(",")[0];
			}


		    searchAjax(searchData , '');	
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
	    }
	});
}
function paginate(is_admin , url){
	var name = $("#icons_list").find(".active").attr('id');
	var searchData = {
            'name'  : name
        };
	if(is_admin == 1){
	    searchData["tagId"] = $('#tag').val();
	    searchData["priority"] = $("#ticketPriority").val();
	    searchData["StartDate"] = document.getElementById("ticketStartDate").value;
	   	searchData["endDate"] = document.getElementById('ticketEndDate').value;
	 	var TechnicalSelect =document.getElementById("ticketTechnical");               
		var options = TechnicalSelect.options;
		searchData["tech"] = options[options.selectedIndex].id.split(",")[0];
	}
	cat_sec = $("#category_list").find(".active").attr('id').split("_");

    if(cat_sec[0] == "cat"){
    	searchData["cat"] = cat_sec[1];
    }
    if(cat_sec[0] == "sec"){
    	searchData["sec"] = cat_sec[1];
    }
     if ($("#sortType").text() == "DESC"){
	 	searchData["sortType"] = "DESC";
	 } 
	 else{
	 	searchData["sortType"] = "ASC";
	 }

	 searchData["sortBy"] = $('#sortBy ').val();
	
	searchAjax(searchData , url);


}
