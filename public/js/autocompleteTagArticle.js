
//$(function() {
//   window.onload = function(){
//    $( "#new-projects" ).load( "/data.php" , function( response, status, xhr){
//        var obj = JSON.parse(response);

//      var obj = [ "aa"  , "bbeii" , "ppp"];
//      console.log(  $( "#tags" ));
//         $( "#tags" ).autocomplete({
//             source: obj
//         }); 
        
//        $( "#new-projects" ).text("");
//        }); 
// };

        
       /* $.ajax({
            type: "GET",
            url: "data.php",
            contenttype: 'json',
            success: function (data) {
                $("#tags").autocomplete({
                    source: JSON.parse(data)
                });
            }
        });*/
  //}
   
    
    
  //});

$(function()
{
   $( "#q" ).autocomplete({
    source: "search/autocomplete",
    minLength: 3,
    select: function(event, ui) {
      $('#q').val(ui.item.value);
    }
  });
});

