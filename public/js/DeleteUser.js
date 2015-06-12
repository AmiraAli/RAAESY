 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function Delete(elm){


  var ids = elm;
  $.ajax({
        url: '/users/'+ids,
        type: 'DELETE',
        success: function(result) {
            $('#'+ids).remove();    
        },
        error: function(jqXHR, textStatus, errorThrown) {
                        // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                        console.log(errorThrown);
        }
   });

}


function Spam(elm){

  var arr = elm.split("_");
  var id = arr[1];
  var spam = 0;
  if (arr[0]=="disable"){
    spam = 1;
  }
    $.ajax({
        url: '/users/spam/'+id,
        type: 'POST',
        data: {
            spam: spam
        },        
        success: function(result) {
            $('#'+id).remove();    
        },
        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
        }
    });

}
