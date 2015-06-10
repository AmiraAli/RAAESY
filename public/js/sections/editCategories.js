 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function EditCat(elm,id){

  $(".disEditCat").attr('disabled','disabled');

         $.ajax({
                url: '/categories/'+id+'/edit',
                type: 'get',
                success: function(result) {
                $(".hideEditCat"+id).hide();
                 $("."+id+"hideEditCat").append(result);    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                }
            });

}

function SaveCatEdit(elm,id,oldname){

 $(".catEditErr").remove();
  name=document.getElementById("exampleInputEmail2").value;
  if(name.trim() == ""){
        $("."+id+"errorcat").append("<div class='catEditErr err' >Category name can not be empty!</div>");
         
	return;
   }

  if(name.trim() == oldname){
        $("."+id+"errorcat").append("<div class='catEditErr err'>please change name!</div>");
         
	return;
   }
         $.ajax({
                url: '/categories/'+id,
                type: 'PUT',
		            data:{name:name},
                success: function(result) {
                    if(result=="NOT DONE"){
			$("."+id+"errorcat").append("<div class='catEditErr err'>Category name already exists!</div>");
			return ;
		    }
                    $(".disEditCat").removeAttr('disabled');
                    document.getElementById(elm).innerHTML=result;  
  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                           
                                console.log(errorThrown);
                }
            });
   

}

function cancelEditCat()
{
  var catid=document.getElementById("idCat").value;
  $(".cancelEditCat").remove();
  $(".catEditErr").remove();
  $(".hideEditCat"+catid).show();
  $(".disEditCat").removeAttr('disabled');
}
