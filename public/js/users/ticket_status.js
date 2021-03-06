 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };

function Status(elm,techid){
  var ticket_id = elm;
  var status =document.getElementById(elm).name;
console.log(techid);
                  
$.ajax({
    url: '/tickets/updatestatus/',
    type: 'post',
    data: { ticket_id: ticket_id,status:status },

    success: function(result) {
	var currentdate = new Date(); 
	var currentDate=currentdate.getFullYear()+"-"+currentdate.getMonth()+"-"+currentdate.getDay()+" "+currentdate.getHours()+":" + 		currentdate.getMinutes() + ":"+ currentdate.getSeconds();
	if($('#'+ticket_id).text()=='closed'){
		$('#'+ticket_id).text('reopen');
		$('#'+ticket_id).attr('name','open');
		var text=document.createTextNode('this ticket has been closed');
		window.location = "http://localhost:8000/tickets/";
		}else{
		   if(!techid){
			takeOverButton=document.createElement("button");
			takeOverButtonText=document.createTextNode("takeover");
			takeOverButton.setAttribute('id',ticket_id+",takeover");
			takeOverButton.setAttribute('onclick','TakeOver('+'"'+ticket_id+',takeover'+'"'+')');
			takeOverButton.appendChild(takeOverButtonText);
			document.getElementById("takeoverajax").insertBefore(takeOverButton,document.getElementById("newelement"));
			}
		   $('#'+ticket_id).text('closed');
		   $('#'+ticket_id).attr('name','close');
		   var text=document.createTextNode('this ticket has been re-opened');
			}
		var leftDiv=document.querySelector("#comments");
		var newLine=document.createElement("br");
		var commentDiv=document.createElement('div');
		  commentDiv.setAttribute("class","panel panel-default  commentbody");
		var headDiv=document.createElement('div');
		  headDiv.setAttribute('class','panel-heading');
		var head=document.createTextNode("name");
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
console.log(result);
var select =document.createElement("select");
select.setAttribute('id','select');
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
document.getElementById(elm).remove();

var saveButton=document.createElement('button');
var saveButtonText=document.createTextNode('save');
saveButton.appendChild(saveButtonText);
saveButton.setAttribute('id','saveButton');
saveButton.setAttribute('onclick','Save('+ticket_id+')');
parentElm.appendChild(saveButton);
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
	 commentDiv.setAttribute("class","panel panel-default  commentbody");

	var commentDiv1=document.createElement('div');
	var headDiv=document.createElement('div');
		  headDiv.setAttribute('class','panel-heading');
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


	$("#select").remove();
	$("#saveButton").remove();

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
}




