var indicator = document.createElement('div');
indicator.className = 'state-indicator';
document.body.appendChild(indicator);
function getDeviceState() {
    var index = parseInt(window.getComputedStyle(indicator).getPropertyValue('z-index'), 10);

    var states = {
        2: 'small-desktop',
        3: 'tablet',
        4: 'phone'
    };

    return states[index] || 'desktop';
}

$(document).ready(function(){
	//$("#advancedSearchDiv").hide();

    $("#toggle").click(function(){
if(getDeviceState() == 'phone') {

    	 var e = document.getElementById("advancedSearchDiv");
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
	

}
else{
    	$("#con").css("css"," table-responsive");
    	$("#con").toggleClass('col-md-8 col-sm-12 table-responsive');

}
        $("#advancedSearchDiv").toggle();

        //remove old data from search
        document.getElementById("advSearchForm").reset();

		search();

    });
});
