$(document).ready(function(){
	     $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });

            $("#createSectionDiv").hide();


});

 




    function tog(elm,elm2){
     
	       $("#"+elm2).toggleClass('glyphicon glyphicon-menu-right');

	        $("."+elm+"category").toggle();
	   

	}




	function createSection(){


	  	$(".alert-success").remove();
	  	$(".alert-danger").remove();
	  	document.getElementById('secName').value ='';
    	$("#con").toggleClass('col-md-8');

        $("#createSectionDiv").toggle();
    
	}


	//--------------------------------------AddComment-----------------------------------------------------------
  function saveSection(){

  	$(".alert-success").remove();
  	$(".alert-danger").remove();
    var  name = document.getElementById('secName').value ;

    if (name.trim() == null || name.trim() == "") {
    	$(".panel-body").prepend("<div class='alert alert-alert'>Section name can not be empty! </div>");
    	return;
    }
   //ajax request
   $.ajax({
    url: '/sections',
    type: 'POST',
    data: {  
   	name: name
   	    },
    success: function(result) {


		if (result == "not done"){
			$(".panel-body").prepend("<div class='alert alert-danger'>Section name already exists</div>");
		}else{	
			var id = result;
			document.getElementById('secName').value ='';
			$(".panel-body").prepend("<div class='alert alert-success'>Section created successfully!</div>");

			$(tbody).append(result);
		}
					},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}
    



