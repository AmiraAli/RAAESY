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
        
        var url = $(this).attr('href');
        show(url);
    });
}

paginateWithAjax();


function init(){
    var input = $("#quickSearch");
    var pos = input.position();
    var width = input.outerWidth();
    var height = input.outerHeight();

    $("#autocompletemenu").css({
        position: "absolute",
        top: (pos.top + height) + "px",
        left: pos.left + "px",
        width: width,
   });

    var flag=true;


    $("#autocompletemenu").mouseover(function(){
        flag = true;
    });

    $("#autocompletemenu").mouseout(function(){
        flag = false;
    
    });



    $("#quickSearch").focusout(function() {

    	if (flag==false){
	    		$("#autocompletemenu").css({
	        	display: "none"
    		});
		}
	});
}

 function myAutocomplete(data) {

 	init();
    data = data.trim();
	if (data==''){ 

		$("#autocompletemenu").css({
        		display: "none"
		});
		return;
	}

	$.ajax({
	    url: '/articles/autocomplete',
	    type: 'POST',
	    data: {  
	   	data: data
   	    },
    success: function(result) {
		result = JSON.parse(result) ; 
		$("#autocompleteul").html('');
		for (var i = 0 ; i< result.length ; i++){
			
			var article = result[i];
		    	$("#autocompleteul").append("<li>"+"<a href= '/articles/"+article['id']+"' > "+article['subject']+" "+"</li>");
			}

			var display="none";
			if (result.length != 0 ){

				display = "block"
     	    }
			
				$("#autocompletemenu").css({
        		display: display
				});
			

		},
	
	error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    }

});




}


function show(url){

    if (url==""){
        url = '/articles/search';
    }
	var category = document.getElementById('cat').value;
	var tag = document.getElementById('tag').value;
	$.ajax({
    url: url ,
    type: 'POST',
    data: {  
   		dataCat: category,
        dataTag: tag,
   	    },
    success: function(result) {
    			var container = document.getElementById('con');
    			container.innerHTML = "";
    			container.innerHTML = result;
    			paginateWithAjax();

			  },
	error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
           }





	});


}
