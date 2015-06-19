
/**
* popup settings  
**/
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
    	html:true,
    	placement: 'left'
    });   
});

/**
* functions of ajaxs tickets
**/
window.onload = function() {
                    $.ajaxSetup({
					                headers: {
					                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
					                }
            					});
            				};


 /**
 * delete function
 **/
function Delete(id){
//ajax request
   $.ajax({
   	dataType: "json",
    url: '/tickets/'+id,
    type: 'DELETE',
    success: function(result) {
		document.getElementById(id).remove(); 
		$("#unansweredCount").html(result["unanswered"]); 
		$("#unassignedCount").html(result["unassigned"]);
		$("#expiredCount").html(result["expired"]);
		$("#openCount").html(result["open"]);
		$("#closedCount").html(result["closed"]);
		$("#allCount").html(result["all"]);
		$("#spamCount").html(result["spam"]);   
	},
	error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
    }
});

}

/**
*spam function
**/
function spam(id){
//ajax request
$.ajax({
		dataType: "json",
		url: '/tickets/spamTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
			document.getElementById(id).remove(); 
			$("#unansweredCount").html(data["unanswered"]); 
			$("#unassignedCount").html(data["unassigned"]);
			$("#expiredCount").html(data["expired"]);
			$("#openCount").html(data["open"]);
			$("#closedCount").html(data["closed"]);
			$("#allCount").html(data["all"]);
			$("#spamCount").html(data["spam"]);
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}

/**
*unspam function
**/

function unspam(id){
console.log(id);
//ajax request
$.ajax({
		dataType: "json",
		url: '/tickets/unSpamTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
			document.getElementById(id).remove(); 
			$("#unansweredCount").html(data["unanswered"]); 
			$("#unassignedCount").html(data["unassigned"]);
			$("#expiredCount").html(data["expired"]);
			$("#openCount").html(data["open"]);
			$("#closedCount").html(data["closed"]);
			$("#allCount").html(data["all"]);
			$("#spamCount").html(data["spam"]);   
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}



/**
*close ticket function
**/
function closeTeckit(id,checkspam,usertype){

	var popupelem=document.getElementById(id+'popup');

//ajax request
$.ajax({
		dataType: "json",
		url: '/tickets/closeTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
					if($('#all').attr('class') != "active" && $('#expired').attr('class') != "active" && $('#unassigned').attr('class') != "active" && $('#unanswered').attr('class') != "active" && $('#spam').attr('class') != "active"){
						document.getElementById(id).remove();
					}else{
							if(checkspam == 0){
								if(usertype == 1){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='spam("+id+")'>Spam</a>|<a onclick='openTeckit("+id+","+checkspam+",1)'>Open</a>|<a onclick='Delete("+id+")'>Delete</a>");
								}else if(usertype == 2){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='openTeckit("+id+","+checkspam+",2)'>Open</a>");
								}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>");	
								}							
							}else{

								if(usertype == 1){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='unspam("+id+")'>unSpam</a>|<a onclick='openTeckit("+id+","+checkspam+",1)'>Open</a>|<a onclick='Delete("+id+")'>Delete</a>");
								}else if(usertype == 2){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='openTeckit("+id+","+checkspam+",2)'>Open</a>");
								}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>");	
								}
							}

							document.getElementById(id+"status").innerHTML="Close";
					}
					$("#unansweredCount").html(data["unanswered"]); 
					$("#unassignedCount").html(data["unassigned"]);
					$("#expiredCount").html(data["expired"]);
					$("#openCount").html(data["open"]);
					$("#closedCount").html(data["closed"]);
					$("#allCount").html(data["all"]);
					$("#spamCount").html(data["spam"]);  
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}

/**
*open ticket function
**/
function openTeckit(id,checkspam,usertype){
	var popupelem=document.getElementById(id+'popup');
//ajax request
$.ajax({
		dataType: "json",
		url: '/tickets/openTicket',
		type: "post",
		data: {'id':id},
		success: function(data){

				if($('#all').attr('class') != "active" && $('#expired').attr('class') != "active" && $('#unassigned').attr('class') != "active" && $('#unanswered').attr('class') != "active" && $('#spam').attr('class') != "active"){
						document.getElementById(id).remove();
					}else{

							if(checkspam == 0){
								if(usertype == 1){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='spam("+id+")'>Spam</a>|<a onclick='closeTeckit("+id+","+checkspam+",1)'>Close</a>|<a onclick='Delete("+id+")'>Delete</a>");
								}else if(usertype == 2){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='closeTeckit("+id+","+checkspam+",2)'>Close</a>");
								}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>");	
								}							
							}else{

								if(usertype == 1){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='unspam("+id+")'>unSpam</a>|<a onclick='closeTeckit("+id+","+checkspam+",1)'>Close</a>|<a onclick='Delete("+id+")'>Delete</a>");
								}else if(usertype == 2){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='closeTeckit("+id+","+checkspam+",2)'>Close</a>");
								}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>");	
								}
							}
							document.getElementById(id+"status").innerHTML="Open";
					}
					$("#unansweredCount").html(data["unanswered"]); 
					$("#unassignedCount").html(data["unassigned"]);
					$("#expiredCount").html(data["expired"]);
					$("#openCount").html(data["open"]);
					$("#closedCount").html(data["closed"]);
					$("#allCount").html(data["all"]);
					$("#spamCount").html(data["spam"]);  

		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}

