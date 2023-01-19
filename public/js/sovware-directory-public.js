;(function($) {

	$(document).on('submit','#listing-form',function(e) {
		e.preventDefault();

		var featuredImage = {
			file: $(".post-thumb")[0].files[0],
		};

		$.ajax({
			// beforeSend: function (xhr) {
			// 	xhr.setRequestHeader("X-WP-Nonce", RestObj.restNonce);
			// },
			headers: {
				"Content-Type": "image/jpeg",
				"Content-Disposition": `attachment; filename=${featuredImage.file.name}`,
			},
			processData: false,
			contentType: false,
			url: RestObj.restURL + "wp/v2/media",
			type: "POST",
			data: featuredImage.file,
			success: function (response) {
console.log(response);

			}
		})

		// $.post(RestObj.restURL+'sovware-directory/v1/submitlisting', data, function(response) {
		// 	if (response.success) {
		// 		console.log(response.success);
		// 	} else {
		// 		alert(response.data.message);
		// 	}
		// })
		// 	.fail(function() {
		// 		alert('errore');
		// 	})


	});

})(jQuery);