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
	console.log(result);
	var select =document.createElement("select");
	select.setAttribute('id','selectallasset');
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

		var saveButton=document.createElement('button');
		var saveButtonText=document.createTextNode('add');
		saveButton.appendChild(saveButtonText);
		saveButton.setAttribute('id','saveassetButton');
		saveButton.setAttribute('onclick','SaveAsset('+ticket_id+')');
		parentElm.appendChild(saveButton);
	}
	else{
		var errorDiv=document.createElement("div");
		errorDiv.setAttribute('class','text-danger');
		var noAssets=document.createTextNode('No New Assets');
		var parentElm=document.getElementById("asseterrormessage");
console.log(parentElm.innerHTML+"aya");
if(parentElm.innerHTML.trim()==""){

		errorDiv.appendChild(noAssets);
	
		parentElm.appendChild(errorDiv);
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

	$("#addnewasset").html("<a href='/assets/'"+result['id']+">"+result['name']+"</a><br>");
	var addasset=document.createElement("button");
	var addassettext=document.createTextNode("AddAssets");
	addasset.setAttribute('id',parseInt(result['ticket_id'])+":newasset");
	addasset.setAttribute('onclick','AddAssets('+'"'+result['ticket_id']+':newasset'+'"'+')');
	var position=document.getElementById("addnewasset");
	var inputHidden=document.createElement("input");
	inputHidden.setAttribute('type','hidden');
	inputHidden.setAttribute('id',asset_id+":showenassets");
	inputHidden.setAttribute('class','showenasset');
	position.appendChild(inputHidden);
	addasset.appendChild(addassettext);
	position.appendChild(addasset);
	$("#selectallasset").remove();
	$("#saveassetButton").remove();

	},
	error: function(jqXHR, textStatus, errorThrown) {
                    // alert('HTTP Error: '+errorThrown+' | Error Message: '+textStatus);
                    console.log(jqXHR.error);
    }
});
}


