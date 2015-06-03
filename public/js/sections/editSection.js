 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function Edit(elm){

console.log(document.getElementById(elm).innerHTML);

  var ids = elm.split(',')[0];


         $.ajax({
                url: '/sections/'+ids+'/edit',
                type: 'get',
                success: function(result) {
                   document.getElementById(elm).innerHTML=result;    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                                console.log(errorThrown);
                }
            });

}


function SaveEdit(elm,oldname){


   var ids = elm.split(',')[0];
   console.log(elm);
   console.log(ids);
   name=document.getElementById("exampleInputEmail1").value;
   $(".alert-danger").remove();
   if(name.trim() == ""){
        $("#sec"+ids).prepend("<div class='alert alert-danger'>Section name can not be empty!</div>");
         
	return;
   }
   if(name.trim() == oldname){
        $("#sec"+ids).prepend("<div class='alert alert-danger'>Change the name please !</div>");
	return;
   }
         $.ajax({
                url: '/sections/'+ids,
                type: 'PUT',
		data:{name:name},
                success: function(result) {
                    if(result=="NOT DONE"){
			$("#sec"+ids).prepend("<div class='alert alert-danger'>Section name already exists!</div>");
			return ;
		    }
                    document.getElementById(elm).innerHTML=result;    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                                console.log(errorThrown);
                }
            });

}
