
 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
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
		result = JSON.parse(result) ; 
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


		$("#tbody").append("<tr id="+row['id']+"><td>"+row['fname']+"</td><td>"+row['lname']+"</td><td>"+row['email']+"</td><td>"+row['phone']+"</td><td>"+row['location']+"</td><td>"+disabledCheckbox+"</td><td><a href='/users/"+row['id']+"'>show</a><a href='/users/"+row['id']+"/edit'>edit</a><a href='#' class='delete' id="+row['id']+" onclick='Delete("+row['id']+")''>delete</a></td></tr>");

		}

		
			},
	error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    }





	});


}
