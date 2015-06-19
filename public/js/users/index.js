
 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });


    

       
    var flag=false;

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
   
    //convert pagination to AJAX
    paginateWithAjax();


 };






//convert pagination to AJAX
function paginateWithAjax(){
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        
        form = $('#advSearchForm');
        $('#displayed').val ( $('input[name=user]:checked').val() );
        data =  form.serializeArray();

        var url = $(this).attr('href');
        url = url.replace("/users/?","/users/ajaxsearch/?");
        
        $.post(url, data ,
        function(data){
            $('#con').html(data);

            //convert refreshing pagination to ajax
            paginateWithAjax();

        });
    });
}




//Autocompete function
function myAutocomplete(data) {

    data = data.trim();
	if (data==''){ 

		$("#autocompletemenu").css({
        		display: "none"
		});
		return;
	}


	$.ajax({
	    url: '/users/autocomplete',
	    type: 'POST',
	    data: {  
	   	data: data
   	    },
    success: function(result) {
		result = JSON.parse(result) ; 
		$("#autocompleteul").html('');
		for (var i = 0 ; i< result.length ; i++){
			
			var user = result[i];
		    	$("#autocompleteul").append("<li>"+"<a href= '/users/"+user['id']+"' > "+user['fname']+" "+user['lname']+"</li>");
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


/* 
 * This function is used in searching users
*/
function search(){

	form = $('#advSearchForm');
    $('#displayed').val ( $('input[name=user]:checked').val() );


    data =  form.serializeArray();

    //trim form values
    for(var i=0 ; i<data.length  ; i++){
        data[i]['value'] = data[i]['value'].trim();
    }


	$.ajax({
    url: '/users/ajaxsearch',
    type: 'POST',
        data: data,
    success: function(result) {
    			var container = document.getElementById('con');
    			container.innerHTML = "";
    			container.innerHTML = result;

                //convert refreshing pagination to ajax
                paginateWithAjax();


			  },
	error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
           }

	});
}


/* 
 * This function is used to reset Advanced Search form
*/
function resetForm(){
    document.getElementById("advSearchForm").reset();
    search();
}
