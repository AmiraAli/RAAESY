 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
//------------------------------------------------------------------------
function Status(elm){
  var ticket_id = elm;
  var status =document.getElementById(elm).name;
techid=document.getElementById("techid").value.split(',')[1];
                  
$.ajax({
    url: '/tickets/updatestatus/',
    type: 'post',
    data: { ticket_id: ticket_id,status:status },

    success: function(result) {
result=JSON.parse(result);
	var currentdate = new Date(); 
	var currentDate=currentdate.getFullYear()+"-"+currentdate.getMonth()+"-"+currentdate.getDay()+" "+currentdate.getHours()+":" + 		currentdate.getMinutes() + ":"+ currentdate.getSeconds();
	
	if($('#'+ticket_id).text()=='close'){
		$('#'+ticket_id).text('reopen');
		$('#'+ticket_id).attr('name','open');
		var text=document.createTextNode('this ticket has been closed');
		window.location = "http://localhost:8000/tickets/";
		}else{
		   if(!techid){
			takeOverButton=document.createElement("button");
			takeOverButtonText=document.createTextNode("Assign To");
			takeOverButton.setAttribute('id',ticket_id+",takeover");
			takeOverButton.setAttribute("class","btn btn-default");
			takeOverButton.setAttribute('onclick','TakeOver('+'"'+ticket_id+',takeover'+'"'+')');
			takeOverButton.appendChild(takeOverButtonText);
			document.getElementById("ass2").appendChild(takeOverButton);

			}
var csrf=$("#hidden").val();

		  $("#addcomments").html(
"     <form name='addForm' method = 'post'  class = 'form-horizontal' action='javascript:add("+ticket_id+")'><input type='hidden' name='_token' value="+csrf+"><div class='form-group col-md-9' ><div class='col-md-12'><textarea type='text' class='form-control' name='body' placeholder='Write Your Comment' rows='3'></textarea></div></div><div class='form-group col-md-1'><div class='col-md-12' style='margin-top:15px;'><button type='submit'  class='btn btn-default' >Comment</button></div></div></form>"
);
		   $('#'+ticket_id).text('close');
		   $('#'+ticket_id).attr('name','close');
		   var text=document.createTextNode('this ticket has been re-opened');
			}
		var leftDiv=document.querySelector("#comments");
		var newLine=document.createElement("br");
		var commentDiv=document.createElement('div');
		  commentDiv.setAttribute("class","panel commentbody");
		var headDiv=document.createElement('div');
		  headDiv.setAttribute('class','panel-heading navbtn txtnav');
		var head=document.createTextNode(result['fname']+" "+result['lname']);
		var commentDiv1=document.createElement('div');
		  commentDiv1.setAttribute("class","panel-body ");

		var textDate=document.createTextNode(currentDate);
		headDiv.appendChild(head);
		commentDiv1.appendChild(text);
		commentDiv1.appendChild(newLine);
		commentDiv1.appendChild(textDate);
		commentDiv.appendChild(headDiv);
		commentDiv.appendChild(commentDiv1);
		leftDiv.appendChild(commentDiv);

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
   

}
//----------------------------------TakeOver------------------------------------------------------------------------
////////////////////////////////////////////////////TakeOverButton//////////////////////////////////////////////
function TakeOver(elm){
 
var ticket_id=elm.split(',')[0];

$.ajax({
    url: '/tickets/takeover/',
    type: 'post',


    success: function(result) {
result=JSON.parse(result)
if(result.length!=0){
var select =document.createElement("select");
select.setAttribute('id','select');
select.setAttribute('class','form-control col-md-1');

for(i=0;i<result.length;i++){
var option=document.createElement("option");
option.setAttribute('id',result[i].id);
var optiontext=document.createTextNode(result[i].fname+" "+result[i].lname);
option.appendChild(optiontext);
select.appendChild(option);
}
document.getElementById(elm).style.display = 'none';
var position=document.getElementById(ticket_id);
var parentElm=document.getElementById("ass");
var spac=document.createElement("br");
spac.setAttribute('class','sp');
var spac2=document.createElement("br");
spac2.setAttribute('class','sp');
parentElm.appendChild(spac);
parentElm.appendChild(spac2);
parentElm.appendChild(select);

parentElm.innerHTML += '&nbsp;&nbsp;&nbsp;&nbsp;';

var saveButton=document.createElement('button');
saveButton.setAttribute('id','saveButton');
saveButton.setAttribute('class','btn btn-primary');
saveButton.setAttribute('onclick','Save('+ticket_id+')');
var spanSaveButton=document.createElement('span');
spanSaveButton.setAttribute('class','glyphicon glyphicon-ok');
saveButton.appendChild(spanSaveButton);
parentElm.appendChild(saveButton);

parentElm.innerHTML += '&nbsp;';

var cancelButton=document.createElement('button');
cancelButton.setAttribute('id','cancelButton');
cancelButton.setAttribute('class','btn btn-danger');
cancelButton.setAttribute('onclick','cancelAssign()');
var spanCancelButton=document.createElement('span');
spanCancelButton.setAttribute('class','glyphicon glyphicon-remove');
cancelButton.appendChild(spanCancelButton);
parentElm.appendChild(cancelButton);

}
else{

var parentElm=document.getElementById("ass2");
var divError=document.createElement("div");
divError.setAttribute("class","text-danger");
var text=document.createTextNode("No techinical available now  ");
divError.appendChild(document.createElement("br"));
divError.appendChild(text);
if(parentElm.innerHTML.trim()==""){
parentElm.appendChild(divError);}
}

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
   

}



////////////////////////////////////////////////////////////SaveButton////////////////////////////////////////////////////////////


function Save(elm){
	var ticket_id=elm;
	var user_id=$("#select").find('option:selected').attr('id');

$.ajax({
    url: '/tickets/save/',
    type: 'post',
    data: { ticket_id: ticket_id,tech_id:user_id },

    success: function(result) {
	result=JSON.parse(result);
	var currentdate = new Date(); 
	var currentDate=currentdate.getFullYear()+"-"+currentdate.getMonth()+"-"+currentdate.getDay()+" "+currentdate.getHours()+":" + 		currentdate.getMinutes() + ":"+ currentdate.getSeconds();
	

	var leftDiv=document.querySelector("#comments");
	var newLine=document.createElement("br");
	var commentDiv=document.createElement('div');
	 commentDiv.setAttribute("class","panel commentbody");

	var commentDiv1=document.createElement('div');
	var headDiv=document.createElement('div');
		  headDiv.setAttribute('class','panel-heading navbtn txtnav');
		var head=document.createTextNode(result['fname']+" "+result['lname']);

	 commentDiv1.setAttribute("class","panel-body ");
	var text=document.createTextNode(result['body']);
	var textDate=document.createTextNode(currentDate);
	headDiv.appendChild(head);
	commentDiv1.appendChild(text);
	commentDiv1.appendChild(newLine);
	commentDiv1.appendChild(textDate);
	commentDiv.appendChild(headDiv);
	commentDiv.appendChild(commentDiv1);
	leftDiv.appendChild(commentDiv);
	$('.tecname').append(result['techname']);

	$("#select").remove();
	$("#saveButton").remove();
	$("#cancelButton").remove();
	$(".sp").remove();

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
}

function cancelAssign()
{
	$("#select").remove();
	$("#saveButton").remove();
	$("#cancelButton").remove();
	$(".sp").remove();
	document.getElementsByClassName("assgn")[0].style.display = 'inline';
}




