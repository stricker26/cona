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
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '/sidebar',
			type: 'POST',
			data: {
				'dataProvince': dataProvince
			},
			success: function(data){
				window.location.href = '/dashboard';
			}, error: function(data){
				alert('error');
			}
		});
	});
});