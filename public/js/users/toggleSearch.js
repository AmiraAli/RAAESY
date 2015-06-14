$(document).ready(function(){
	$("#advancedSearchDiv").hide();

    $("#toggle").click(function(){

    	$("#con").toggleClass('col-md-9');

        $("#advancedSearchDiv").toggle();

        //remove old data from search
        document.getElementById("advSearchForm").reset();

		search();

    });
});
