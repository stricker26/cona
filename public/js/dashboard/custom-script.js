jQuery(document).ready(function($){
	$('.loader').hide("fast");
	$('.body-toload').show("fast");

	$('.dropdown-submenu a.test').on("click", function(e){
		if($(this).next('ul').hasClass('click')){
			$(this).next('ul').hide().removeClass('click');
		} else {
			$('.dropdown-submenu').find('ul').each(function(){
				$(this).hide().removeClass('click');
			});
			$(this).next('ul').show().addClass('click');
		}
		e.stopPropagation();
		e.preventDefault();
	});

	$('.dropdown-menu .dropdown-submenu .submenu a').on('click', function(){
		var dataProvince = $(this).data("value");
		dataProvince = dataProvince.split(',');
		console.log(this);
	});
});