
 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
//-------------------------------------DeleteComment--------------------------------------------------------------
function Delete(elm){
  var ids = elm.name.split("_");
   $.ajax({
    url: '/tickets/'+ids[1]+'/comments/'+ids[0],
    type: 'DELETE',
    success: function(result) {
		$('#'+ids[0]+"Comments").remove();    
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});

}


//------------------------------EditComment------------------------------------------------------------------------------------
function edit(elm){
	var ids = elm.name.split("_");
var body=elm.id;
console.log(body);
   //ajax request
   $.ajax({
    url: '/tickets/'+ids[1]+'/comments/'+ids[0]+'/edit',
    type: 'get',
    
    success: function(result) {
		$("#"+ids[0]+"Comments").html("<textarea type='text' class='form-control' id='bodyedit'>"+body+"</textarea><button class='btn btn-primary buttonsave' onclick='SaveComment("+ids[0]+','+ids[1]+")'>Save</button>");
			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});

}

//---------------------------------
function SaveComment(commentid,ticketid){

var body=document.getElementById("bodyedit").value;
console.log(body);
$.ajax({
    url: '/tickets/'+ticketid+'/comments/'+commentid,
   type: 'put',
   data:{body:body}, 
    success: function(result) {
//name from session
result=JSON.parse(result);
		$("#"+commentid+"Comments").html("<div class='panel-heading'>"+result['fname']+" "+result['lname']+"</div><div class='panel-body'>"+"<button id='"+body+"'name="+commentid+"_"+ticketid+" onclick='edit(this)' class='btn btn-primary buttonright' >Edit</button>	<button name="+commentid+"_"+ticketid+" onclick='Delete(this)' class='btn btn-primary buttonright'>Delete</button>"+body+"<br>"+result['updated_at']);
			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}
//--------------------------------------AddComment-----------------------------------------------------------
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

		$("#comments").append("<div class='panel panel-default  commentbody' id="+result['id']+"Comments"+"><div class='panel-heading'>"+result['fname']+" "+result['lname']+"</div><div class='panel-body'>"+"<button id='"+body+"'name="+result['id']+"_"+ticketId+" onclick='edit(this)' class='btn btn-primary buttonright' >Edit</button>	<button name="+result['id']+"_"+ticketId+" onclick='Delete(this)' class='btn btn-primary buttonright'>Delete</button>"+body+"<br>"+result['created_at']+"</div>");
		document.forms["addForm"]["body"].value = '';
			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}
//------------------------------------------------------------------------------------------------------------------
