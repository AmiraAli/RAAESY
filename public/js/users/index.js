
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



function show(elm){

	var type = elm.value;
	

	$.ajax({
    url: '/users/get_user_types',
    type: 'POST',
    data: {  
   	type: type
   	    },
    success: function(result) {

    	$("#tbody").html(result);
		/*result = JSON.parse(result) ; 
		console.log(result);
		$("#tbody").html('');
		var disabledCheckbox ;

		for (var i = 0 ; i< result.length ; i++){
			
			var row = result[i];
			
			disabledCheckbox = "<input type='checkbox' disabled='true' ";
			if ( row['isspam'] == "1" ){
				disabledCheckbox +=  " checked='true'>";
			}else{
				disabledCheckbox += " >";
			}

*/
		//$("#tbody").html("<tr id="+row['id']+"><td>"+row['fname']+"</td><td>"+row['lname']+"</td><td>"+row['email']+"</td><td>"+row['phone']+"</td><td>"+row['location']+"</td><td>"+disabledCheckbox+"</td><td><a href='/users/"+row['id']+"'>show</a><a href='/users/"+row['id']+"/edit'>edit</a><a href='#' class='delete' id="+row['id']+" onclick='Delete("+row['id']+")''>delete</a></td></tr>");

//		}

		
			},
	error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    }





	});


}

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

