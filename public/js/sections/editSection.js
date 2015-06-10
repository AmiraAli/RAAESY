 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function Edit(elm){

var ids = elm.split(',')[0];
$('#_'+ids).hide();

   $.ajax({
          url: '/sections/'+ids+'/edit',
          type: 'get',
          success: function(result) {
            $(".do").attr('disabled','disabled');
           $(".hideEdit"+ids).hide();
           $("#"+ids).append(result);   
          },
          error: function(jqXHR, textStatus, errorThrown) {
              // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
              console.log(errorThrown);
          }
      });

}


function SaveEdit(elm,oldname){

   var ids = elm.split(',')[0];
   var currentArrow=$(".hideEdit"+ids).attr("class");
   name=document.getElementById("exampleInputEmail1").value;
     $(".cat").remove();
   if(name.trim() == ""){
        $('._'+ids).prepend("<div class='cat err'>Section name can not be empty!</div>");
         
	return;
   }
   if(name.trim() == oldname){
        $('._'+ids).prepend("<div class='cat err'>Change the name please !</div>");
	return;
   }
         $.ajax({
                url: '/sections/'+ids,
                type: 'PUT',
		data:{name:name},
                success: function(result) {
                    if(result=="NOT DONE"){
			$('._'+ids).prepend("<div class='cat err'>Section name already exists!</div>");
			return ;
		    }
                    $(".do").removeAttr('disabled');
                    document.getElementById(elm).innerHTML=result;
                    $("#"+name).removeClass('glyphicon glyphicon-triangle-right hideEdit'+ids);
                    $("#"+name).addClass(currentArrow);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                                console.log(errorThrown);
                }
            });

}

function cancelEditSec()
{
  var sectionid=document.getElementById("idSect").value;
  $(".cancelEdit").remove();
  $(".cat").remove();
  $('#_'+sectionid).show();
  $(".do").removeAttr('disabled');
  $(".hideEdit"+sectionid).show();
}
