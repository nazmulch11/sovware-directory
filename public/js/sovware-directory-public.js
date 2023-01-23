;(function($) {

	$(document).on('submit','#listing-form',function(e) {
		e.preventDefault();

		var Image = $(".thumbnail")[0].files[0];

		$.ajax({
			beforeSend: function (xhr) {
				xhr.setRequestHeader("X-WP-Nonce", RestObj.restNonce);
			},
			headers: {
				"Content-Type": "image/jpeg",
				"Content-Disposition": `attachment; filename=${Image.name}`,
			},
			processData: false,
			contentType: false,
			url: RestObj.restURL + "wp/v2/media",
			type: "POST",
			data: Image,
			success: function (response) {

				$('input[name=featured_image]').val(response.id ?? 0);
				let formdata = $('#listing-form').serialize();

				$.post(RestObj.restURL+'sovware-directory/v1/submitlisting', formdata, function(response) {
					if (response) {
						$('#show_msg').text(response.massage)
					} else {
						$('#show_msg').text('response not present')
					}
				})
					.fail(function() {
						$('#show_msg').text('response not present')
					})
			}
		})
	});


	//Step 4
	$(document).on('click', '.pagination a', function(e) {
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		get_posts(page);
	});

	function get_posts(page) {
		$.ajax({
			url : my_pagination.ajax_url,
			type : 'post',
			data : {
				action : 'get_posts',
				paged : page,
				post_type : my_pagination.post_type,
				posts_per_page : my_pagination.posts_per_page
			},
			success : function( response ) {
				// Step 5
				$('#content').html(response);
			}
		});
	}

})(jQuery);