(function($) {

	jQuery(document).ready(function() {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});

		jQuery('#position').change(function() {

			var position = jQuery(this).val();

			if(position == 'Governor' || position == 'Vice-Governor' || position == 'Provincial Board Member') {

				jQuery('.district-wrapper').fadeOut(500);
				jQuery('.city-wrapper').fadeOut(500);
				jQuery('#district').removeAttr('required');
				jQuery('#city').removeAttr('required');
				jQuery('#district').html('<option value="">Select District *</option>');
				jQuery('#city').html('<option value="">Select City *</option>');

			} else if(position == 'Congressman') {

				jQuery('.district-wrapper').fadeIn(500);
				jQuery('.city-wrapper').fadeOut(500);
				jQuery('#district').attr('required', 'required');
				jQuery('#city').removeAttr('required');

			} else if(position == 'HUC Congressman') {

			} else if(position == 'City Mayor' || position == 'City Vice Mayor' || position == 'City Councilor') {

				jQuery('.district-wrapper').fadeIn(500);
				jQuery('.city-wrapper').fadeIn(500);
				jQuery('#city').attr('required', 'required');
				jQuery('#district').attr('required', 'required');

			} else if(position == 'Municipal Mayor' || position == 'Municipal Vice-Mayor' || position == 'Municipal Councilor') {

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