
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

   //ajax request
   $.ajax({
    url: '/tickets/'+ids[1]+'/comments/'+ids[0]+'/edit',
    type: 'get',
    
    success: function(result) {
    document.getElementById(body).style.display = 'none';
    $("[name="+ids[0]+"_"+ids[1]+"_dl]").css("display", "none");
    $('.cmtbtn').attr('disabled','disabled');
    $("#"+ids[0]+"combdy2").hide();
    $("#"+ids[0]+"combdy").append("<div class='col-md-9 cmtedt'><textarea type='text' class='form-control' rows='3' id='bodyedit'>"+body+"</textarea></div><div class='col-md-3 cmtedt'> <button class='btn btn-primary buttonsave' onclick='SaveComment("+ids[0]+','+ids[1]+")'><span class='glyphicon glyphicon-ok'></span></button><button onclick='cancelEditCmt("+ids[0]+','+ids[1]+")' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> </button> </div>");

      },
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});

}

//---------------------------------
function SaveComment(commentid,ticketid){

var body=document.getElementById("bodyedit").value;

$.ajax({
    url: '/tickets/'+ticketid+'/comments/'+commentid,
   type: 'put',
   data:{body:body}, 
    success: function(result) {
//name from session
    result=JSON.parse(result);
    $('.cmtedt').remove();
    $("#"+commentid+"combdy2").show();
   // $('.cmtbtn').show();
   $('.cmtbtn').removeAttr('disabled');
    $("[name="+commentid+"_"+ticketid +"]").attr('id', body);
		$("#"+commentid+"combdy2").html(body+"<br>"+result['updated_at']);
    $("[name="+commentid+"_"+ticketid +"]").css("display", "inline");
    $("[name="+commentid+"_"+ticketid +"_dl]").css("display", "inline");
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
//console.log(result);
		$("#comments").append("<div class='panel  commentbody' id="+result['id']+"Comments"+"><div class='panel-heading navbtn txtnav'>"+result['fname']+" "+result['lname']+"</div><div class='panel-body'>"+"<button name="+result['id']+"_"+ticketId+"_dl onclick='Delete(this)' class='btn btn-link buttonright'><span class='glyphicon glyphicon-remove' style='color:#d82727;'></span></button> <button id='"+body+"'name="+result['id']+"_"+ticketId+" onclick='edit(this)' class='btn btn-link buttonright cmtbtn' ><span class='glyphicon glyphicon-pencil'></span></button><div id="+result['id']+"combdy><div id="+result['id']+"combdy2>"+body+"<br>"+result['created_at']+"</div></div></div>");
		document.forms["addForm"]["body"].value = '';
			},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}
//------------------------------------------------------------------------------------------------------------------
function cancelEditCmt(commentid,ticketid)
{
  $('.cmtedt').remove();
  $("#"+commentid+"combdy2").show();
  //$('.cmtbtn').show();
  $("[name="+commentid+"_"+ticketid +"]").css("display", "inline");
  $("[name="+commentid+"_"+ticketid +"_dl]").css("display", "inline");
  $('.cmtbtn').removeAttr('disabled');
}