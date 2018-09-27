$(document).ready(function(){
	$('#edit_btn').on('click', function(){
		$('.lec-data').find(".row-body").each(function(){
			console.log(this);
		});
	});

	$('.dropdown-menu .dropdown-submenu .submenu a').on('click', function(event){
		event.preventDefault();
		var dataProvince = $(this).data("value");
		var data = dataProvince.split(',');
		var e = data[0];
		var name = data[2];
		var type = data[1];
		var region = data[3];
		$('tbody').html('');
		if (path == '/lec/screening') {
			if (type == 'DISTRICT') {
	    		ajaxGet(e, name, 'MUNICIPALITY');
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else if (type == 'PROVINCE') {
	    		ajaxGet(e, name, type, region);
	    		ajaxGet(e, name, 'HUC', region);
	    		ajaxGet(e, name, 'CITY', region);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').hide(500);
	    		$('.gov-governor').show(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else {
	    		ajaxGet(e, name, type, region);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
	    	}
	    	$('html, body').animate({
		        scrollTop: $("#tableGeo").offset().top
		    }, 1000);
	    }
	    else {
	    	window.location.href = 'lec/screening?e=' + e + '&name=' + name + '&type=' + type + '&region=' + region;
	    }
	});
});