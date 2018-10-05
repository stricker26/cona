$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function(){
	var a_href_id = ['prof_fb','prof_twitter','prof_ig','prof_website'];
	$('#edit_btn').on('click', function(){
		$('.data-candidates .left-div').find(".row-body").each(function(){
			$(this).find(".row-content span").hide();
			$(this).find(".row-content input").show();

			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").hide();
			}
		});

		$('.data-candidates .right-div').find(".row-body").each(function(){
			$(this).find(".row-content span").hide();
			$(this).find(".row-content input").show();

			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").hide();
			}
		});

		$('#approve_btn_1').hide();
		$('#reject_btn_1').hide();
		$('#download_btn').hide();
		$('#save_btn').show();
		$('#close_btn').show();
		$(this).hide();
	});

	$('#close_btn').on('click', function() {
		$('.data-candidates .left-div').find(".row-body").each(function(){
			var inputData = $(this).find(".row-content span").html();
			$(this).find(".row-content span").show();
			if(inputData == '<i>--None--</i>') {
				$(this).find(".row-content input").hide();
			} else {
				$(this).find(".row-content input").val(inputData).hide();
			}

			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('.data-candidates .right-div').find(".row-body").each(function(){
			var inputData = $(this).find(".row-content span").html();
			$(this).find(".row-content span").show();
			if(inputData == '<i>--None--</i>') {
				$(this).find(".row-content input").hide();
			} else {
				$(this).find(".row-content input").val(inputData).hide();
			}
			
			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('#approve_btn_1').show();
		$('#reject_btn_1').show();
		$('#download_btn').show();
		$('#save_btn').hide();
		$('#edit_btn').show();
		$(this).hide();
	});

	$('#save_btn').on('click', function(e){
		e.preventDefault();
		var prof_id = $('.data-candidates #prof_id').val();
		var objectData = { id:prof_id };

		$('.data-candidates .left-div').find(".row-body").each(function(){
			var spanData = $(this).find(".row-content input").val();
			// $(this).find(".row-content span").html(spanData).show();
			// $(this).find(".row-content input").hide();
			
			var idForAjax = $(this).find(".row-content input").attr("id");
			var nameToPass = idForAjax.replace("prof_","");
			console.log(nameToPass);
			objectData[nameToPass] = spanData;

			// if($.inArray(idForAjax, a_href_id) !== -1) {
			// 	$(this).find("a").show();
			// }
		});

		$('.data-candidates .right-div').find(".row-body").each(function(){
			var spanData = $(this).find(".row-content input").val();
			// $(this).find(".row-content span").html(spanData).show();
			// $(this).find(".row-content input").hide();
			
			var idForAjax = $(this).find(".row-content input").attr("id");
			var nameToPass = idForAjax.replace("prof_","");
			console.log(nameToPass);
			objectData[nameToPass] = spanData;

			// if($.inArray(idForAjax, a_href_id) !== -1) {
			// 	$(this).find("a").show();
			// }
		});

		$('#approve_btn_1').show();
		$('#reject_btn_1').show();
		$('#download_btn').show();
		$('#close_btn').hide();
		$('#edit_btn').show();
		$(this).hide();
		console.log(objectData);

		$.ajax({
			method: 'POST',
			url: '/'+part+'/screening/profile/sent',
			data: objectData,
			success:function(alert){
	    		if(alert == 'cos failed') {
		    		$('#alert-handler').show().delay(2000).fadeOut();
		    		$('#alert-handler .failed-alert').show().delay(2000).fadeOut();
		    		$('#alert-handler .failed-alert .alert-danger .message-text').html("  Chief of Staff Saving Failed");
	    		} else if(alert == 'candidate failed') {
		    		$('#alert-handler').show().delay(2000).fadeOut();
		    		$('#alert-handler .failed-alert').show().delay(2000).fadeOut();
		    		$('#alert-handler .failed-alert .alert-danger .message-text').html("  Candidate Saving Failed");
	    		} else {
		    		$('#alert-handler').show().delay(2000).fadeOut();
		    		$('#alert-handler .success-alert').show().delay(2000).fadeOut();
		    		$('#alert-handler .success-alert .alert-success .message-text').html("  Saving Success!");
		    	}
		    	$('html, body').animate({
			        scrollTop: $(".right-panel .container").offset().top
			    }, 400);

			    $('.data-candidates .left-div').find(".row-body").each(function(){
					var spanData = $(this).find(".row-content input").val();
					if(spanData == '') {
						$(this).find(".row-content span").html("<i>--None--</i>").show();
					} else {
						$(this).find(".row-content span").html(spanData).show();
					}
					$(this).find(".row-content input").hide();
					
					var idForAjax = $(this).find(".row-content input").attr("id");

					if($.inArray(idForAjax, a_href_id) !== -1) {
						$(this).find("a").show();
					}
				});

				$('.data-candidates .right-div').find(".row-body").each(function(){
					var spanData = $(this).find(".row-content input").val();
					if(spanData == '') {
						$(this).find(".row-content span").html("<i>--None--</i>").show();
					} else {
						$(this).find(".row-content span").html(spanData).show();
					}
					$(this).find(".row-content input").hide();
					
					var idForAjax = $(this).find(".row-content input").attr("id");

					if($.inArray(idForAjax, a_href_id) !== -1) {
						$(this).find("a").show();
					}
				});
	    	},
	    	error:function(alert){
	    		$('#alert-handler').show().delay(2000).fadeOut();
	    		$('#alert-handler .failed-alert').show().delay(2000).fadeOut();
	    		$('#alert-handler .failed-alert .alert-danger .message-text').html("  Edit failed");
		    	$('html, body').animate({
			        scrollTop: $(".right-panel .container").offset().top
			    }, 400);

				$('.data-candidates .left-div').find(".row-body").each(function(){
					var inputData = $(this).find(".row-content span").html();
					$(this).find(".row-content span").show();
					if(inputData == '<i>--None--</i>') {
						$(this).find(".row-content input").hide();
					} else {
						$(this).find(".row-content input").val(inputData).hide();
					}

					var idForAjax = $(this).find(".row-content input").attr("id");
					if($.inArray(idForAjax, a_href_id) !== -1) {
						$(this).find("a").show();
					}
				});

				$('.data-candidates .right-div').find(".row-body").each(function(){
					var inputData = $(this).find(".row-content span").html();
					$(this).find(".row-content span").show();
					if(inputData == '<i>--None--</i>') {
						$(this).find(".row-content input").hide();
					} else {
						$(this).find(".row-content input").val(inputData).hide();
					}

					var idForAjax = $(this).find(".row-content input").attr("id");
					if($.inArray(idForAjax, a_href_id) !== -1) {
						$(this).find("a").show();
					}
				});
	    	}
		});
	});

	$('#approve_btn').on('click', function(){
		var id_candidate = $('#id_candidate').val();
		$.ajax({
			method: 'POST',
			url: 'profile/approve',
			data: { "id": id_candidate},
			success:function(data)  
	    	{
	    		location.reload();
	    	}
		});
	});

	$('#lec_approve_btn').on('click', function(){
		var id_candidate = $('#id_candidate').val();
		$.ajax({
			method: 'POST',
			url: 'profile/approve',
			data: { "id": id_candidate},
			success:function(data)  
	    	{
	    		location.reload();
	    	}
		});
	});

	$('#reject_btn').on('click', function(){
		var id_candidate = $('#id_candidate').val();
		$.ajax({
			method: 'POST',
			url: 'profile/reject',
			data: { "id": id_candidate},
			success:function(data)  
	    	{
	    		location.reload();
	    		
	    	} 
		});
	});

	$('#download_btn').on('click', function() {
	});
});

	