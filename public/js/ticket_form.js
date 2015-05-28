
window.onload = function() {
                    $.ajaxSetup({
					                headers: {
					                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
					                         }
            					  });
            				 };

/**
*function to show new subject form 
**/
function add_new_subject () {
	document.getElementById("subject_select").style.visibility = "hidden";
	document.getElementById("subject_new").style.visibility = "visible";
}

/**
*function to get new subject value 
**/
function submit_subject () {
	var newsubj= document.getElementById("new_subjvalue").value;
	if (newsubj != ""){
		//ajax request
		$.ajax({
		      url: '/tickets/addSubject',
		      type: "post",
		      data: {'newsubj':newsubj},
		      success: function(data){
		        var select= document.getElementById("subject_select");
		        var option = document.createElement("option");
					option.text = newsubj;
					option.value= data;
					option.setAttribute("selected","true");
					select.add(option);		       
				    select.style.visibility = "visible";
				document.getElementById("subject_new").style.visibility = "hidden";
		      },
			  error: function(jqXHR, textStatus, errorThrown) {
				alert("May be subject is already exists or something wrong!!....");
			  }
		    });
	}else{
		alert("Please Enter subject value!!...");
	}
}

/**
* ajax requests for auto complete search by tags
**/
$(document).ready(function(){
    $("#search").keyup(function(){ 
     var name= $("#search").val();
     var parsed=[];
     //ajax request
		$.ajax({
		      url: '/tickets/getTags',
		      type: "post",
		      data: {'q':name},
		      datatype:'json',
		      success: function(data){
		        for (var i = 0; i < JSON.parse(data).length; i++) {
		        	parsed[i]=JSON.parse(data)[i]['name'];
		        	// alert(parsed[i]);
		        };
		        // alert(parsed);
			       $( "#search" ).autocomplete({
						source: parsed
					});
     		      },
			  error: function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			  }
		    });
  		});
	}); 