$(document).ready(function(){
	     $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });

  
});

function tog(elm,elm2){
  
  $("#"+elm2).toggleClass('glyphicon glyphicon-triangle-right').toggleClass('glyphicon glyphicon-triangle-bottom');

  $("#table_show"+elm).toggle();


}
//--------------------------------------------------------------------------------------
function createSection(){

  	$(".secsaveError").remove();
    $('.newTicket').hide();
    var nodeSec=$('<div class="contn"><div class="col-md-5 mySecError" ></div>'+           
          '<div class="col-md-4 " style="display:inline;">'+
          '<input type="text" class="form-control" id="secName" placeholder="Section Name">'+
          '</div>'+
        '<div class="form-group" style="display:inline;">'+
          '<div class="col-md-3 ">'+
            '<button type="submit" onclick="saveSection()" class="btn btn-primary "><span class="glyphicon glyphicon-ok"></span> </button>&ensp; &ensp;'+
            '<button  onclick="cancelAddSec()" class="btn btn-danger "><span class="glyphicon glyphicon-remove"></span> </button>'+
          '</div></div></div>');
     $(".newSect").append(nodeSec);
    
	}

  //-------------------------------------------------------------------------------------------------------------
function createCategory(secId , secName ){

  $(".disBut").attr('disabled','disabled');

  $("#_"+secId).hide();
  $('.'+secId+'removeButton').hide();
  var node=$('<div class="beforAlert"><div class="col-md-6 addCat " style="display:inline;">'+
        '<input type="text" class="form-control addCat" id="catName" placeholder="Category Name"></div>'+
        '<div class="form-group addCat" style="display:inline;">'+
            '<div class="col-md-6 ">'+
              '<button type="submit" onclick="saveCategory()" class="btn btn-primary "><span class="glyphicon glyphicon-ok"></span> </button>&ensp; &ensp;'+
              '<button  onclick="cancelAddCat()" class="btn btn-danger "><span class="glyphicon glyphicon-remove"></span> </button>'+
              '<input type="hidden"  id="cat_secId" >'+
              '<input type="hidden"  id="cat_secName">'+
           ' </div></div></div>');
  $("._"+secId).append(node);

  document.getElementById('cat_secName').value = secName;
  document.getElementById('cat_secId').value = secId;    
    
  }
	//--------------------------------------AddComment-----------------------------------------------------------
  function saveSection(){

  	$(".secsaveError").remove();

    var  name = document.getElementById('secName').value ;

    if (name.trim() == null || name.trim() == "") {
    	$(".mySecError").prepend("<div class='secsaveError err'>Section name can not be empty! </div>");
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
			$(".mySecError").prepend("<div class='secsaveError err'>Section name already exists</div>");
		}else{	
       
        $("#con").append(result);
        $(".secsaveError").remove();
        $(".contn").remove();
        $('.newTicket').show();
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

    $(".catsaveError").remove();

    if (categoryname.trim() == null || categoryname.trim() == "") {
      $("."+sectionid+"error").prepend("<div class='catsaveError err'>Category name can not be empty! </div>");
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
                  $("."+sectionid+"error").prepend("<div class='catsaveError err'>Category name already exists</div>");
            }else{  
                  $('#'+sectionid+'categories').append(result); 
                  $(".beforAlert").remove();
                  $(".catsaveError").remove();
                  $("#_"+sectionid).show();
                  $('.'+sectionid+'removeButton').show();
                  $(".disBut").removeAttr('disabled');
                  
            } 
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
          }
      });
  }
    
function cancelAddCat()
{
  var sectionid=document.getElementById("cat_secId").value;
  $(".beforAlert").remove();
  $(".catsaveError").remove();
  $("#_"+sectionid).show();
  $('.'+sectionid+'removeButton').show();
  $(".disBut").removeAttr('disabled');
}

function cancelAddSec()
{
  $(".secsaveError").remove();
  $(".contn").remove();
  $('.newTicket').show();
 
}

