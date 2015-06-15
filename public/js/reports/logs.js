//convert pagination to AJAX
function paginateWithAjax(){
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        

        var url = $(this).attr('href');
        
        $.post(url, "" ,
        function(data){
            $('#con').html(data);

            //for css style 
            init();
            
            //convert refreshing pagination to ajax
            paginateWithAjax();


        });
    });
}


window.onload = function() {

  	init();
	 

	$.ajaxSetup({
    	headers: {
        	'X-XSRF-Token': $('meta[name="_token"]').attr('content')
    	}
	});

	paginateWithAjax();

 	
}









