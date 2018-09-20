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

		$('#approve_btn').hide();
		$('#reject_btn').hide();

		$('#save_btn').show();
		$('#close_btn').show();
		$(this).hide();
	});

	$('#close_btn').on('click', function() {
		$('.data-candidates .left-div').find(".row-body").each(function(){
			var inputData = $(this).find(".row-content span").html();
			$(this).find(".row-content span").show();
			$(this).find(".row-content input").val(inputData).hide();

			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('.data-candidates .right-div').find(".row-body").each(function(){
			var inputData = $(this).find(".row-content span").html();
			$(this).find(".row-content span").show();
			$(this).find(".row-content input").val(inputData).hide();

			var idForAjax = $(this).find(".row-content input").attr("id");
			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('#approve_btn').show();
		$('#reject_btn').show();

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
			$(this).find(".row-content span").html(spanData).show();
			$(this).find(".row-content input").hide();
			
			var idForAjax = $(this).find(".row-content input").attr("id");
			console.log(idForAjax);
			var nameToPass = idForAjax.replace("prof_","");
			objectData[nameToPass] = spanData;

			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('.data-candidates .right-div').find(".row-body").each(function(){
			var spanData = $(this).find(".row-content input").val();
			$(this).find(".row-content span").html(spanData).show();
			$(this).find(".row-content input").hide();
			
			var idForAjax = $(this).find(".row-content input").attr("id");
			console.log(idForAjax);
			var nameToPass = idForAjax.replace("prof_","");
			objectData[nameToPass] = spanData;

			if($.inArray(idForAjax, a_href_id) !== -1) {
				$(this).find("a").show();
			}
		});

		$('#approve_btn').show();
		$('#reject_btn').show();

		$('#close_btn').hide();
		$('#edit_btn').show();
		$(this).hide();

		// $.ajaxSetup({
		// 	headers: {
		// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		// 	}
		// });

		// $.ajax({
		// 	method: 'POST',
		// 	url: '/dashboard/profile/sent',
		// 	data: objectData,
		// 	success:function(alert){
	 //    		$('#alert-handler').show().delay(2000).fadeOut();
	 //    		$('#alert-handler .success-alert').show().delay(2000).fadeOut();
	 //    	},
	 //    	error:function(alert){
	 //    		$('#alert-handler').show().delay(2000).fadeOut();
	 //    		$('#alert-handler .failed-alert').show().delay(2000).fadeOut();
	 //    	}
		// });
	});

	$('#approve_btn').on('click', function(){
		alert("approved!");
	});

	$('#reject_btn').on('click', function(){
		alert("reject!");
	});
});

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}