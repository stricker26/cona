$(document).ready(function(){
	$('#edit_btn').on('click', function(){
		$('.lec-data').find(".row-body").each(function(){
			console.log(this);
		});
	});
});