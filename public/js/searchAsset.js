window.onload = function() {
        $.ajaxSetup({
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
        });


        //convert pagination to AJAX
        paginateWithAjax();

        };


        //convert pagination to AJAX
        function paginateWithAjax(){
            $('.pagination a').on('click', function(e){
                e.preventDefault();
                
                var url = $(this).attr('href');
                url = url.replace("/assets/?","/assets/searchAssets/?");
                
                searchAsset(url);

                });
    }
            
function searchAsset(url){

            if (url==''){
                url = '/assets/searchAssets';
            }
        	var formData = {
            'name'  : $('#model_name').val(),
            'type': $('#type').val(),
            'manufacturer' : $('#manufacturer').val(),
            'serialno' : $('#serialno').val(),
            'location' : $('#location').val()

        }; 

		   $.ajax({
			    url: url,
			    type: 'post',
			    data: formData,
			    success: function(result) {
					$('#search_result').html(result);

                    //convert refreshing pagination to ajax
                    paginateWithAjax();

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}