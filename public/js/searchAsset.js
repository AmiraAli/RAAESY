window.onload = function() {
                    $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
            };
            
function searchAsset(id){

        	var formData = {
            'name'  : $('#model_name').val(),
            'type': $('#type').val(),
            'manufacturer' : $('#manufacturer').val(),
            'serialno' : $('#serialno').val(),
            'location' : $('#location').val()

        }; 

		   $.ajax({
			    url: '/assets/searchAssets',
			    type: 'post',
			    data: formData,
			    success: function(result) {
					 $('#search_result').html(result);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}