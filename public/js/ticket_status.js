 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function Status(elm){
  var ticket_id = elm;
  var status =document.getElementById(elm).name;
techid=document.getElementById("techid").value.split(',')[1];
console.log(techid);
console.log(techid);
                  
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
			takeOverButton.setAttribute('onclick','TakeOver('+'"'+ticket_id+',takeover'+'"'+')');
			takeOverButton.appendChild(takeOverButtonText);
			document.getElementById("takeoverajax").insertBefore(takeOverButton,document.getElementById("newelement"));

			}
var csrf=$("#hidden").val();
console.log(csrf);
		  $("#addcomments").html(
"     <form name='addForm' method = 'post'  class = 'form-horizontal' action='javascript:add("+ticket_id+")'><div class='form-group'><input type='hidden' name='_token' value="+csrf+"><div class='col-md-6'><textarea type='text' class='form-control' name='body' ></textarea></div></div><div class='form-group'><div class='col-md-6 col-md-offset-4'><button    type='submit'  class='btn btn-primary' >Add comment</button></div></div></form>"
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

console.log(document.getElementById(elm));
                  console.log(ticket_id);
$.ajax({
    url: '/tickets/takeover/',
    type: 'post',


    success: function(result) {
result=JSON.parse(result)
//console.log(result+"aya");
if(result.length!=0){
var select =document.createElement("select");
select.setAttribute('id','select');
select.setAttribute('class','form-control');
// select.className += " "+'col-md-4';
for(i=0;i<result.length;i++){
var option=document.createElement("option");
option.setAttribute('id',result[i].id);
var optiontext=document.createTextNode(result[i].fname+" "+result[i].lname);
option.appendChild(optiontext);
select.appendChild(option);
}
var position=document.getElementById(ticket_id);
var parentElm=document.getElementById("newelement");
parentElm.appendChild(select);
document.getElementById(elm).style.display = 'none';

var saveButton=document.createElement('button');
var saveButtonText=document.createTextNode('save');
saveButton.appendChild(saveButtonText);
saveButton.setAttribute('id','saveButton');
saveButton.setAttribute('class','btn btn-default');
saveButton.setAttribute('onclick','Save('+ticket_id+')');
parentElm.appendChild(saveButton);

var cancelButton=document.createElement('button');
var cancelButtonText=document.createTextNode('cancel');
cancelButton.appendChild(cancelButtonText);
cancelButton.setAttribute('id','cancelButton');
cancelButton.setAttribute('class','btn btn-default');
cancelButton.setAttribute('onclick','cancel()');
parentElm.appendChild(cancelButton);

}
else{

var parentElm=document.getElementById("newelement");
var divError=document.createElement("div");
divError.setAttribute("class","text-danger");
var text=document.createTextNode("No techinical available now  ");
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
	$('.assigned').append(result['techname']);

	$("#select").remove();
	$("#saveButton").remove();

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
}

function cancel ()
{
	$("#select").remove();
	$("#saveButton").remove();
	$("#cancelButton").remove();
	var c= document.getElementsByClassName("assgn")[0].style.display = 'inline';
}




