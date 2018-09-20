(function($) {

	jQuery(document).ready(function() {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});

		jQuery('#province').change(function(event) {

			var provinceID = jQuery(this).val();

			jQuery('#district').html('<option>Loading...</option>');

			$.ajax({
				url: '/geo',
				method: 'GET',
				data: {requestType: 'district', requestValue: provinceID},
				success: function(data) {
					jQuery('#district').html(data);
				},
				error: function(data) {
					console.log(data);
				}
			});

			event.preventDefault();

		});

		jQuery('#district').change(function() {

			var district = jQuery(this).val();

			jQuery('#city').html('<option>Loading...</option>');

			$.ajax({
				url: '/geo',
				method: 'GET',
				data: {requestType: 'city', requestValue: district},
				success: function(data) {
					jQuery('#city').html(data);
				},
				error: function(data) {
					console.log(data);
				}
			});

			event.preventDefault();

		});

	});


})(jQuery);