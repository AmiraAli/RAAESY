 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
function Edit(elm){


  var ids = elm;


         $.ajax({
                url: '/sections/'+elm+'/edit',
                type: 'get',
                success: function(result) {
                    $('#'+ids).html(result);    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                                console.log(errorThrown);
                }
            });

}


function SaveEdit(elm){


  var ids = elm;
name=document.getElementById("exampleInputEmail1").value;

         $.ajax({
                url: '/sections/'+elm,
                type: 'PUT',
		data:{name:name},
                success: function(result) {
                    $('#'+ids).html(result);    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                                // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                                console.log(errorThrown);
                }
            });

}
