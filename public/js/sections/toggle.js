$(document).ready(function(){
	     $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });

            $("#createSectionDiv").hide();
            $("#createCategoryDiv").hide();



});

 




    function tog(elm,elm2){
     
	       $("#"+elm2).toggleClass('glyphicon glyphicon-menu-right');

	        $("."+elm+"category").toggle();
	   

	}




	function createSection(){

	  	$(".alert-danger").remove();
	  	document.getElementById('secName').value ='';

      if ($(createCategoryDiv).is(":visible")){

        $("#createCategoryDiv").hide();  
        $("#createSectionDiv").show();  

      }else{
        $("#con").toggleClass('col-md-8');
        $("#createSectionDiv").toggle();
      
      }
    	
      
	}

  //-------------------------------------------------------------------------------------------------------------
function createCategory(secId , secName){


      //check if same button is pressed or another one of another section
      var oldSecName = document.getElementById('cat_secName').value;

      $(".alert-danger").remove();
      document.getElementById('catName').value ='';
      document.getElementById('cat_secName').value = secName;
      document.getElementById('cat_secId').value = secId;



      if ($(createSectionDiv).is(":visible") ){

          $("#createSectionDiv").hide();
          $("#createCategoryDiv").show();
      }else{

          if ( oldSecName == secName){
            $("#con").toggleClass('col-md-8');
            $("#createCategoryDiv").toggle();
          }else{
              document.getElementById("con").className= 'col-md-8' ;
              $("#createCategoryDiv").show();
          }

      }

      
    
  }
	//--------------------------------------AddComment-----------------------------------------------------------
  function saveSection(){


    $("#createCategoryDiv").hide();
  	$(".alert-danger").remove();

    var  name = document.getElementById('secName').value ;

    if (name.trim() == null || name.trim() == "") {
    	$(".panel-body").prepend("<div class='alert alert-danger'>Section name can not be empty! </div>");
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
        $("#con").toggleClass('col-md-8');
        $("#createSectionDiv").toggle();
        $("#con").append(result);
		}
					},
	error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
    }
});
}

//---------------------------------------------------------------------------------


  function saveCategory() {
    var categoryname=document.getElementById("catName").value;
    var sectionid=document.getElementById("cat_secId").value;

    $(".alert-danger cat").remove();


    if (categoryname.trim() == null || categoryname.trim() == "") {
      $(".panel-body").prepend("<div class='alert alert-danger'>Category name can not be empty! </div>");
      return;
    }

    $.ajax({
          url: '/categories/saveCategory',
          type: 'POST',
          data:{
            "sectionid":sectionid, 
            "categoryname":categoryname
          },
          success: function(result) {


            if (result == "not done"){
                  $(".panel-body").prepend("<div class='alert alert-danger cat'>Category name already exists</div>");
            }else{  
                  $("#con").toggleClass('col-md-8');
                  $("#createCategoryDiv").toggle();
                  $('#'+sectionid+'categories').append(result);  
            } 
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
          }
      });
  }
    



