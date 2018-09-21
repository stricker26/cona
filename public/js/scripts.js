(function($) {

	jQuery(document).ready(function() {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});

		jQuery('#position').on("change", function(event) {

			var position = jQuery(this).val();
			var groupType = jQuery('option:selected',this).data('group');

			jQuery('.region-wrapper').fadeOut(500);
			jQuery('.province-wrapper').fadeOut(500);
			jQuery('.city-wrapper').fadeOut(500);
			jQuery('.district-wrapper').fadeOut(500);
			jQuery('.huc-city-wrapper').fadeOut(500);

			if(position != 'Senator') {
				jQuery('.region-wrapper').fadeIn(500);
				jQuery('#region').attr('required', 'required');
				jQuery('#region').removeAttr('required');
			} else {
				jQuery('.region-wrapper').fadeOut(500);
				jQuery('.province-wrapper').fadeOut(500);
				jQuery('.city-wrapper').fadeOut(500);
				jQuery('.district-wrapper').fadeOut(500);
				jQuery('.huc-city-wrapper').fadeOut(500);
				jQuery('#region').attr('required', 'required');
			}

		});

		jQuery('#region').change(function() {

			var region = jQuery(this).val();
			var position = jQuery('#position').val();
			var groupType = jQuery('option:selected', jQuery('#position')).data('group');

			jQuery('.province-wrapper').fadeIn(500);
			jQuery('#province').html('<option>Loading...</option>');

			if(groupType == 'PROV') {

				$.ajax({
					url: '/geo',
						method: 'GET',
						data: {requestType: 'province', requestValue: region},
						success: function(data) {
							jQuery('#province').html(data);
						},
						error: function(data) {
							console.log(data);
						}
				});

			} else {

				if(region != 'NCR' && (position == 'City Mayor' || position == 'City Vice Mayor' || position == 'City Councilor')) {

					$.ajax({
						url: '/geo',
							method: 'GET',
							data: {requestType: 'hybrid_province', requestValue: region},
							success: function(data) {
								jQuery('#province').html(data);
							},
							error: function(data) {
								console.log(data);
							}
					});

				} else {

					$.ajax({
						url: '/geo',
							method: 'GET',
							data: {requestType: 'huc_province', requestValue: region},
							success: function(data) {
								jQuery('#province').html(data);
							},
							error: function(data) {
								console.log(data);
							}
					});
				}

			}

		});

		jQuery('#province').change(function() {

			var provinceID = jQuery(this).val();
			var region = jQuery('#region').val();
			var groupType = jQuery('option:selected', jQuery('#position')).data('group');

			if(groupType == 'HUC' && region == 'NCR') {
				var requestType = 'huc_district';
				if(jQuery('#position').val() == 'HUC Congressman') {
					jQuery('.district-wrapper').fadeIn(500);
					jQuery('.huc-city-wrapper').fadeOut(500);
					var target = '#district';
				} else {
					jQuery('.huc-city-wrapper').fadeOut(500);
				}
			} else if(groupType == 'HUC' && region != 'NCR') {
				if(jQuery('#position').val() == 'HUC Congressman') {
					jQuery('.huc-city-wrapper').fadeOut(500);
				} else {
					var requestType = 'cc_huc';
					var target = '#huc-city';
					jQuery('.huc-city-wrapper').fadeIn(500);
				}
			} else {
				var requestType = 'district';
				var target = '#district';
				var position = jQuery('#position').val();
				if(position == 'Congressman' || position == 'Municipal Mayor' || position == 'Municipal Vice-Mayor' || position == 'Municipal Councilor') {
					jQuery('.district-wrapper').fadeIn(500);
					jQuery('#district').html('<option>Loading...</option>');
				} else {
					jQuery('.district-wrapper').fadeOut(500);
				}
				
			}

			$.ajax({
				url: '/geo',
				method: 'GET',
				data: {requestType: requestType, requestValue: provinceID},
				success: function(data) {
					jQuery(target).html(data);
				},
				error: function(data) {
					console.log(data);
				}
			});

		});

		jQuery('#huc-city').change(function() {

			
			var city = jQuery(this).val();
			var region = jQuery(this).val();
			var position = jQuery('#position').val();

			if(region != 'NCR' && (position == 'City Mayor' || position == 'City Vice Mayor' || position == 'City Councilor')) {

				jQuery('.district-wrapper').fadeOut(500);

			} else {

				jQuery('.district-wrapper').fadeIn(500);
				jQuery('#district').html('<option>Loading...</option>');

				$.ajax({
					url: '/geo',
					method: 'GET',
					data: {requestType: 'huc_district', requestValue: city},
					success: function(data) {
						jQuery('#district').html(data);
					},
					error: function(data) {
						console.log(data);
					}
				});
			}

		});

		jQuery('#district').change(function() {

			var district = jQuery(this).val();
			var province_code = jQuery('option:selected',this).data('province');
			var position = jQuery('#position').val();
			var groupType = jQuery('option:selected', jQuery('#position')).data('group');

			if(groupType == 'HUC') {

				jQuery('.city-wrapper').fadeOut(500);

			} else {

				jQuery('#city').html('<option>Loading...</option>');

				if(position == 'Congressman') {
					jQuery('.city-wrapper').fadeOut(500);
				} else {

					if(position == 'City Mayor' || position == 'City Vice Mayor' || position == 'City Councilor') {
						jQuery('.city-wrapper').fadeOut(500);
					} else {
						jQuery('.city-wrapper').fadeIn(500);
					}

					$.ajax({
						url: '/geo',
						method: 'GET',
						data: {requestType: 'city', requestValue: district, provinceCode: province_code},
						success: function(data) {
							jQuery('#city').html(data);
						},
						error: function(data) {
							console.log(data);
						}
					});
				}
			}

		});

	});


})(jQuery);