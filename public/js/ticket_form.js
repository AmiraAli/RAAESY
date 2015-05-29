
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
* global array of tags selected 
**/
var tags_array = new Array();
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
		        };
			       $( "#search" ).autocomplete({
						source: parsed,
						change: function( event, ui ) {
						console.log(ui['item']['value']);
						tag_value=ui['item']['value'];
						//append the selected tags && check if this tags is
						//selected before or not
						if(tags_array.indexOf(tag_value) <= -1)
							{
								tags_array.push(tag_value);
								var tags=document.getElementById("tags_selected");
								var span=document.createElement("span");
								span.innerHTML=tag_value+" ";
								span.setAttribute("class","btn btn-primary");
								span.setAttribute("id",tag_value);
								var remove_span=document.createElement("span");
								remove_span.setAttribute("class","badge");
								remove_span.setAttribute("onclick","remove_tag('"+tag_value+"')");
								remove_span.innerHTML="x";
								span.appendChild(remove_span);
								tags.appendChild(span);
							}
							check_tags_array();
						}
					});
     		      },
			  error: function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			  }
		    });
  		});
	}); 

/**
* function to remove tags on click
**/
function remove_tag (tag_value) {
	var i = tags_array.indexOf(tag_value);
	tags_array.splice(i, 1);
	document.getElementById(tag_value).remove();
	check_tags_array ();
}
/**
* function to check the status of tags array
**/
function check_tags_array () {
	
	if(tags_array.length == 1 ){

		if (document.getElementById('done') == null){

			var tags=document.getElementById("tags_selected");   
			var done=document.createElement("a");
			done.setAttribute("onclick","submit_tags()");
			done.setAttribute("class","pull-right");
			done.setAttribute("id","done");
			done.innerHTML="Done";
			tags.appendChild(done);
		}
		
	}

	if(tags_array.length == 0 ){
	   document.getElementById("done").remove();
	}
	
}

/**
* function to send the all tags selected to the form
**/
function submit_tags () {
	document.getElementById("tags_selected").style.visibility = "hidden";
	var tags_field=document.getElementById("tagValues");
	tags_field.value=tags_array.toString();
}

/**
* text editor jquery
**/
$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});