
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
   

 };



function myAutocomplete(data) {

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

function search(){

	var fname = document.getElementById('fname').value;
	var lname = document.getElementById('lname').value;
	var email = document.getElementById('email').value;
	var phone = document.getElementById('phone').value;
	var location = document.getElementById('location').value;

    var displayedUsers  =  $('input[name=user]:checked').val() ; 

	$.ajax({
    url: '/users/ajaxsearch',
    type: 'POST',
    data: {  
        displayed: displayedUsers,
   		fname: fname,
        lname: lname,
        email: email,
        phone: phone,
        location: location,
   	    },
    success: function(result) {
    			var container = document.getElementById('con');
    			container.innerHTML = "";
    			container.innerHTML = result;
			  },
	error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
           }





	});


}
