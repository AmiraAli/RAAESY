 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function EditCat(elm,id){
	//alert("test");

	console.log(document.getElementById(elm).innerHTML);

         $.ajax({
                url: '/categories/'+id+'/edit',
                type: 'get',
                success: function(result) {
                   document.getElementById(elm).innerHTML=result;    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                }
            });

}


function SaveCatEdit(elm,id,oldname){

 $(".alert-danger").remove();
  name=document.getElementById("exampleInputEmail2").value;
  if(name.trim() == ""){
        $("#yarab"+id).prepend("<div class='alert alert-danger'>Category name can not be empty!</div>");
         
	return;
   }

  if(name.trim() == oldname){
        $("#yarab"+id).prepend("<div class='alert alert-danger'>please change name!</div>");
         
	return;
   }
         $.ajax({
                url: '/categories/'+id,
                type: 'PUT',
		data:{name:name},
                success: function(result) {
                    if(result=="NOT DONE"){
			$("#yarab"+id).prepend("<div class='alert alert-danger'>Category name already exists!</div>");
			return ;
		    }
                    document.getElementById(elm).innerHTML=result;  
  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                           
                                console.log(errorThrown);
                }
            });
   

}
