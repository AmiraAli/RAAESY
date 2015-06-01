
alert ("ok");
window.onload = function() {


    var dialog, form;
 
	var name = $( "#title" );
	var allFields = $( [] ).add( name );
	form = document.forms[0];


 function validateForm(){

	var flag = true;
	checkName = name[0].value.trim(); 
	if (checkName == ''){
		$('.validateTips').html ("Category name can not be empty");
		name.addClass( "ui-state-error" );
		flag = false;
	}
	
	return flag;
}

//--------------------------------------
   function addItem() {
	var valid = true;
	valid = validateForm();	

      if ( valid ) {
      allFields.removeClass( "ui-state-error" );
      return valid;
  }
 }
//------------------------------------------

//jQuery pop-up code using jQuery libraries 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create category": addItem,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
      		form.reset();
   		allFields.removeClass( "ui-state-error" );
      }
    });
  //-----------------------------------------
 
    $( "#submit" ).button().on( "click", function() {
	addItem();
    });

    $( "#create-cat" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
  //});

}