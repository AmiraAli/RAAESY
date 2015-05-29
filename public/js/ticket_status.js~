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
