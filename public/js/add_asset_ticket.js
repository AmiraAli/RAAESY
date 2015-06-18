 window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
////////////////////////////////////////////////////AddAssetsButton//////////////////////////////////////////////
function AddAssets(elm){
	var ticket_id=elm.split(':')[0];
	var asset_id=elm.split(':')[2];
	var showenAssetId=[];
	showenasset=document.querySelectorAll(".showenasset");
	for(input=0;input<showenasset.length;input++){
		showenAssetId.push(showenasset[input].id.split(":")[0]);
		}
           
$.ajax({
    url: '/assets/addasset',
    type: 'post',
    success: function(result) {
	result=JSON.parse(result)
	var select =document.createElement("select");
	select.setAttribute('id','selectallasset');
	select.setAttribute('class','form-control');
	var flag=0;
	for(i=0;i<result.length;i++){
	if(showenAssetId.indexOf(result[i].id)>-1){
		continue;
	}else{
		flag=1;
		var option=document.createElement("option");
		option.setAttribute('id',result[i].id+",asset");
		var optiontext=document.createTextNode(result[i].name);
		option.appendChild(optiontext);
		select.appendChild(option);
		}
	}
	if(flag){
		var position=document.getElementById(ticket_id);
		var parentElm=document.getElementById("addnewasset");
		parentElm.appendChild(select);
		document.getElementById(elm).remove();

		// var saveButton=document.createElement('button');
		// var saveButtonText=document.createTextNode('add');
		// saveButton.appendChild(saveButtonText);
		// saveButton.setAttribute('id','saveassetButton');
		// saveButton.setAttribute('onclick','SaveAsset('+ticket_id+')');
		// parentElm.appendChild(saveButton);
		$("#addnewasset").append("&ensp;<button id='saveassetButton' type='submit' class='btn btn-primary' onclick='SaveAsset("+ticket_id+")'><span class='glyphicon glyphicon-ok'></span></button>");
		$("#addnewasset").append("&ensp;<button class='btn btn-danger' onclick='cancel("+ticket_id+")'><span class='glyphicon glyphicon-remove'></span></button>");
		$("#addnewasset").append("<br><a href='/assets/create' class='navtxt add-asset'>Add new asset</a>");
		

	}
	else{
		var errorDiv=document.createElement("div");
		errorDiv.setAttribute('class','text-danger');
		var noAssets=document.createTextNode('No New Assets');
		var parentElm=document.getElementById("asseterrormessage");
if(parentElm.innerHTML.trim()==""){

		errorDiv.appendChild(noAssets);
	
		parentElm.appendChild(errorDiv);
		$("#asseterrormessage").append("<a href='/assets/create' class='navtxt add-asset'>Add new asset</a>")
		}
		
	}
	
	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
   



}



////////////////////////////////////////////////////////////SaveButton////////////////////////////////////////////////////////////


function SaveAsset(elm){
	var ticket_id=elm;
	var option_id=$("#selectallasset").find('option:selected').attr('id');
	asset_id=option_id.split(',')[0];


$.ajax({
    url: '/assets/saveassets/',
    type: 'post',
    data: { ticket_id: ticket_id,asset_id:asset_id },

    success: function(result) {
	
	result=JSON.parse(result);


	$("#new-asset").append("<div id="+asset_id+"_"+ticket_id+"><span class='btn'><a href='/assets/'"+result['id']+"><span class='asset'>"+result['name']+"</span></a><span class='badge' onclick='remove_asset("+asset_id+","+ticket_id+")'>x</span></span></div>");
	// var addasset=document.createElement("button");
	// var addassettext=document.createTextNode("Add Asset");
	// addasset.setAttribute('id',parseInt(result['ticket_id'])+":newasset");
	// addasset.setAttribute('onclick','AddAssets('+'"'+result['ticket_id']+':newasset'+'"'+')');
	// var position=document.getElementById("addnewasset");
	var hposition=document.getElementById(asset_id+"_"+ticket_id);
	var inputHidden=document.createElement("input");
	inputHidden.setAttribute('type','hidden');
	inputHidden.setAttribute('id',asset_id+":showenassets");
	inputHidden.setAttribute('class','showenasset');
	hposition.appendChild(inputHidden);
	// addasset.appendChild(addassettext);
	// position.appendChild(addasset);
	$("#addnewasset").html("<button id='"+parseInt(result['ticket_id'])+":newasset' onclick="+'AddAssets('+'"'+result['ticket_id']+':newasset'+'"'+')'+" class='btn btn-default'><span class='glyphicon glyphicon-plus'></span>  Add Asset</button>");
	$("#selectallasset").remove();
	$("#saveassetButton").remove();

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
}

function remove_asset(asset_id, ticket_id){
	$.ajax({
	    url: '/assets/removeAsset/',
	    type: 'post',
	    data: { ticket_id: ticket_id,asset_id:asset_id },

	    success: function(result) {
			$("#"+asset_id+"_"+ticket_id).remove();
			$("#asseterrormessage").html("");
		},
		error: function(jqXHR, textStatus, errorThrown) {
            // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
            console.log(jqXHR.error);
	    }
	});
}
function cancel(ticket_id){
	$("#addnewasset").html("<button id='"+ticket_id+":newasset' onclick="+'AddAssets('+'"'+ticket_id+':newasset'+'"'+')'+" class='btn btn-default'><span class='glyphicon glyphicon-plus'></span>  Add Asset</button>");

}


