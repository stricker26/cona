var path = window.location.pathname;
jQuery(document).ready(function($){
	$('.loader').hide();
	$('.body-toload').show();

	$('.dropdown-submenu a.test').on("click", function(e){
		if($(this).next('ul').hasClass('click')){
			$(this).next('ul').hide("fast").removeClass('click');
		} else {
			$('.dropdown-submenu').find('ul').each(function(){
				$(this).hide().removeClass('click');
			});
			$(this).next('ul').show(500).addClass('click');
		}
		e.stopPropagation();
		e.preventDefault();
	});

	$('.checkbox label').hover(function(){
		$(this).find('.cr').css("borderColor","#c4a925");
	}, function(){
		$(this).find('.cr').css("borderColor","#808080");
	});

	//status candidates click
	$('#left-panel #main-menu .stat-check span').on('click', function(){
		var value = $(this).data("value");
		console.log(value);
		$('#left-panel #statusCandidates #statusData').val(value);
		$('#left-panel #statusCandidates').submit();
	});

	$('.dropdown-menu .dropdown-submenu .submenu a').on('click', function(){
		var dataProvince = $(this).data("value");
		var data = dataProvince.split(',');
		var e = data[0];
		var name = data[2];
		var type = data[1];
		var region = data[3];
		$('tbody').html('');
		if (path == '/hq/screening') {
			if (type == 'DISTRICT') {
	    		ajaxGet(e, name, 'MUNICIPALITY');
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
	    	}
	    	else if (type == 'PROVINCE') {
	    		ajaxGet(e, name, type, region);
	    		ajaxGet(e, name, 'HUC', region);
	    		ajaxGet(e, name, 'CITY', region);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').hide(500);
	    		$('.gov-governor').show(500);
	    	}
	    	else {
	    		ajaxGet(e, name, type, region);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
	    	}
	    	$('html, body').animate({
		        scrollTop: $("#tableGeo").offset().top
		    }, 1000);
	    }
	    else if (path == '/hq/screening/profile') {
	    	window.location.href = '../screening?e=' + e + '&name=' + name + '&type=' + type + '&region=' + region;
	    }
	    else {
	    	window.location.href = 'screening?e=' + e + '&name=' + name + '&type=' + type + '&region=' + region;
	    }
	});

	function ajaxGet(e, name, type, region) {
		$.ajax({
			method: 'GET',
			url: '/hq/screening/' + type + '/' + e,
			success:function(data)  
	    	{
	    		if (data == '') {
	    		}
	    		else  {
	    			if (name != undefined && name != '') {
	    				if (type != 'CITY') {
	    					if (type == 'PROVINCE' || (type == 'HUC' && region == 'NCR')) {
		    					$('.bcrumbs').html('<a href="" id="' + region + '" class="REGION">REGION ' + region + '</a> <p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
		    				}
		    				else {
		    					if ($('#' + e).length == 0)
		    						$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
		    				}
	    				}
	    			}
	    			switch (type) {
	    				case 'HUC':
	    					hucTable(e, data, region);
	    				break;
	    				case 'PROVINCE':
	    					districtTable(e, data);
	    				break;
	    				case 'CITY':
	    					cityTable(e, data, name);
	    				break;
	    			}
	    			//loadTable(e, data);
	    		}
	    		$('#locationModal').html(name);
	    		$('.screenLocation').html(name);
	    	} 
		});
	}
});