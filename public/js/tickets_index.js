
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


// $('#all').live('click', function() {

//     // alert($(this).index());
//     alert("done");

// });
 /**
 * delete function
 **/
function Delete(id){
//ajax request
   $.ajax({
    url: '/tickets/'+id,
    type: 'DELETE',
    success: function(result) {
		document.getElementById(id).remove();    
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
		url: '/tickets/spamTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
			document.getElementById(id).remove();    
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
		url: '/tickets/unSpamTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
			console.log("success");
			document.getElementById(id).remove();    
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}



/**
*close ticket function
**/
function closeTeckit(id,checkspam){

	var popupelem=document.getElementById(id+'popup');

//ajax request
$.ajax({
		url: '/tickets/closeTicket',
		type: "post",
		data: {'id':id},
		success: function(data){
					if($('#all').attr('class') != "active"){
						document.getElementById(id).remove();
					}else{
							if(checkspam == 0){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='spam("+id+")'>Spam</a>|<a onclick='openTeckit("+id+","+checkspam+")'>Open</a>|<a onclick='Delete("+id+")'>Delete</a>");
							}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='unspam("+id+")'>unSpam</a>|<a onclick='openTeckit("+id+","+checkspam+")'>Open</a>|<a onclick='Delete("+id+")'>Delete</a>");
							}
							document.getElementById(id+"status").innerHTML="Close";
					}
		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}

/**
*open ticket function
**/
function openTeckit(id,checkspam){
	var popupelem=document.getElementById(id+'popup');
//ajax request
$.ajax({
		url: '/tickets/openTicket',
		type: "post",
		data: {'id':id},
		success: function(data){

				if($('#all').attr('class') != "active"){
						document.getElementById(id).remove();
					}else{
							if(checkspam == 0){
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='spam("+id+")'>Spam</a>|<a onclick='closeTeckit("+id+","+checkspam+")'>Close</a>|<a onclick='Delete("+id+")'>Delete</a>");
							}else{
								popupelem.setAttribute("data-content","<a href='/tickets/"+id+"'>Show</a>|<a href='/tickets/"+id+"/edit'>Edit</a>|<a onclick='unspam("+id+")'>unSpam</a>|<a onclick='closeTeckit("+id+","+checkspam+")'>Close</a>|<a onclick='Delete("+id+")'>Delete</a>");
							}
							document.getElementById(id+"status").innerHTML="Open";
					}

		    },
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
			}
   });
}

