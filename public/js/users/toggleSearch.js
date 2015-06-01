$(document).ready(function(){
	$("#advancedSearchDiv").hide();
    $("#toggle").click(function(){

    	$("#con").toggleClass('col-md-8');

        $("#advancedSearchDiv").toggle();
    });
});
