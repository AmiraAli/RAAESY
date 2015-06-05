$(document).ready(function(){
	$("#advancedSearchDiv").hide();

    $("#toggle").click(function(){

    	$("#con").toggleClass('col-md-8');

        $("#advancedSearchDiv").toggle();

        //remove old data from search
        document.getElementById('fname').value = '';
		document.getElementById('lname').value = '';
		document.getElementById('email').value = '';
		document.getElementById('phone').value = '' ; 
		document.getElementById('location').value = '';

		search();

    });
});
