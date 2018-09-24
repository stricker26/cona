$(document).ready(function(){
	$('.card-header-click').on('click', function(){
		$(this).next('.card-body').slideToggle();
		if($(this).find('i').hasClass('fa-caret-down')){
			$(this).find('i').removeClass().addClass('fas fa-caret-up pt-1');
		} else {
			$(this).find('i').removeClass().addClass('fas fa-caret-down pt-1');
		}
	});
});