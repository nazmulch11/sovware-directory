;(function($) {

	$(document).on('submit','#listing-form',function(e) {
		e.preventDefault();
		var data = $(this).serialize();
		$.post(RestObj.restURL+'sovware-directory/v1/submitlisting', data, function(response) {
			if (response.success) {
				console.log(response.success);
			} else {
				alert(response.data.message);
			}
		})
			.fail(function() {
				alert('errore');
			})

	});

})(jQuery);