jQuery(document).ready(function($){
	$('.loader').hide("fast");
	$('.body-toload').show("fast");

	$('.dropdown-submenu a.test').on("click", function(e){
		$(this).next('ul').toggle();
		e.stopPropagation();
		e.preventDefault();
	});

	$('.dropdown-menu .dropdown-submenu .submenu a').on('click', function(){
		var dataProvince = $(this).data("value");
		dataProvince = dataProvince.split(',');
		$('.loaderGeo').show();

		ajaxGet(dataProvince[0],dataProvince[1]);

		$('#tableGeo').ready(function(){
			$('.table-geo').show();
			$('.loaderGeo').hide();
			$('.bcrumbs p').remove();
			$('.bcrumbs a').remove();
		});
	});
});