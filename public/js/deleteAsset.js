		function deleteAsset(id){
			//ajax request
		   $.ajax({
			    url: '/assets/'+id,
			    type: 'DELETE',
			    success: function(result) {
					 $('#'+id).remove();    
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
			    }
			});

		}