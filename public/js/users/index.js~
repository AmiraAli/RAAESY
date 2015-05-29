
 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function Delete(elm){


  var ids = elm.name.split("_");

	//ajax request
   $.ajax({
    url: '/tickets/'+ids[1]+'/comments/'+ids[0],
    type: 'DELETE',
    success: function(result) {
		$('#'+ids[0]).remove();    
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});

}

//---------------------------------
function edit2(elm){


	var ids = elm.name.split("_");

	console.log($("#"+ids[0]+ "> .panel" ));
   $("#"+ids[0]+ "> .panel > .panel-body").html('	<textarea type="text" class="form-control" name="body" ></textarea>');
}
//----

function edit(elm){


	var ids = elm.name.split("_");

   //ajax request
   $.ajax({
    url: '/tickets/'+ids[1]+'/comments/'+ids[0],
    type: 'PUT',
    data: {  
   	body: "changeddd"
    },
    success: function(result) {
		alert ("done");
			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});

}


function add(ticketId){

    var  body = document.forms["addForm"]["body"].value ;

    if (body.trim() == null || body.trim() == "") {
    	return;
    }

   //ajax request
   $.ajax({
    url: '/tickets/'+ticketId+'/comments',
    type: 'POST',
    data: {  
   	body: body
   	    },
    success: function(result) {
		result = JSON.parse(result) ; 
		var edited = "";
		if (result['created_at']!= result['updated_at']){
			edited = "Edited: ";
		}

		$("#comments").append("<div class='row' id="+result['id']+"><div class='panel panel-default'><div class='panel-heading'>"+result['username']+"<b></b><span>"+edited+result['updated_at']+"</span></div><div class='panel-body'><p>"+body+"</p><button name="+result['id']+"_"+ticketId+" onclick='edit(this)' class='btn btn-primary' >Edit</button>	<button name="+result['id']+"_"+ticketId+" onclick='Delete(this)' class='btn btn-primary'>Delete</button></div>");
		document.forms["addForm"]["body"].value = '';

			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});


}

