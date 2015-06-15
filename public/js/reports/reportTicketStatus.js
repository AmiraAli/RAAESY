


 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });

            //convert pagination to AJAX
			paginateWithAjax();

}                


function toggle(idticket){
     

     $("."+idticket).toggle();
      

}


//convert pagination to AJAX
function paginateWithAjax(){
  
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        
        var url = $(this).attr('href');
        $.post(url, "" ,
        function(data){
            $('#con').html(data);

            
            //convert refreshing pagination to ajax
            paginateWithAjax();


        });
    });
}