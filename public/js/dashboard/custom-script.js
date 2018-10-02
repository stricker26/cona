var path = window.location.pathname;
var part = path.split('/')[1];

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

	//hq status candidates click
	//whole Philippines
	$('#left-panel #main-menu .stat-check span').on('click', function(){
		var value = $(this).data("value");
		console.log(value);
		$('#left-panel #statusCandidates #statusData').val(value);
		$('#left-panel #statusCandidates').submit();
	});
	//regional and provincial
	$('#left-panel #main-menu .dropdown-menu li .reg-stat span').on('click', function(){
		var value = $(this).data("value");
		console.log(value);
		$('#left-panel #statusCandidates #statusData').val(value);
		$('#left-panel #statusCandidates').submit();
	});

	$('.dropdown-menu .dropdown-submenu .submenu a').on('click', function(event){
		event.preventDefault();
		var dataProvince = $(this).data("value");
		console.log(this);
		var data = dataProvince.split(',');
		var e = data[0];
		var name = data[2];
		var type = data[1];
		var region = data[3];
		$('tbody').html('');
		if (path == '/' + part + '/screening') {
			if (type == 'DISTRICT') {
				console.log('CLICKED DISTRICT: e: ' + e + ', name: ' + name + ', type: ' + type + ', region: ' + region);
	    		ajaxGet(e, name, 'MUNICIPALITY', undefined, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else if (type == 'PROVINCE') {
	    		console.log('CLICKED PROVINCE: e: ' + e + ', name: ' + name + ', type: ' + type + ', region: ' + region);
	    		ajaxGet(e, name, type, region, part);
	    		ajaxGet(e, name, 'HUC', region, part);
	    		ajaxGet(e, name, 'CITY', region, part);
	    		getProvinceCandidate(e, type, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').hide(500);
	    		$('.gov-governor').show(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else {
	    		console.log('CLICKED ELSE: e: ' + e + ', name: ' + name + ', type: ' + type + ', region: ' + region);
	    		ajaxGet(e, name, type, region, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
	    	}
	    	$('html, body').animate({
		        scrollTop: $("#tableGeo").offset().top
		    }, 1000);
	    }
	    else if (path == '/hq/screening/profile' || path == '/lec/screening/profile') {
	    	window.location.href = '../screening?e=' + e + '&name=' + name + '&type=' + type + '&region=' + region;
	    }
	    else {
	    	window.location.href = '/' + part + '/screening?e=' + e + '&name=' + name + '&type=' + type + '&region=' + region;
	    }
	});

	function ajaxGet(e, name, type, region, part) {
		$.ajax({
			method: 'GET',
			url: '/' + part + '/screening/' + type + '/' + e,
			success:function(data)  
	    	{
	    		console.log(e);
	    		console.log(name);
	    		console.log(type);
	    		console.log(region);
	    		console.log(part);
	    		if (data == '') {
	    			if (type == 'PROVINCE' || (type == 'HUC' && region == 'NCR')) {
						console.log('type: ' + type);
						$('.bcrumbs').html('<a href="" id="' + region + '" class="REGION">REGION ' + region + '</a> <p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
					}
	    		}
	    		else  {
	    			if (name != undefined && name != '') {
	    				if (type != 'CITY') {
	    					if (type == 'PROVINCE' || (type == 'HUC' && region == 'NCR')) {
		    					$('.bcrumbs').html('<a href="" id="' + region + '" class="REGION">REGION ' + region + '</a> <p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');				
					    		console.log(data);
		    				}
		    				else {
		    					if ($('#' + e).length == 0) {
						    		console.log(data);
		    						$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
		    					}
					    		console.log(data);
		    				}
				    		console.log(data);
	    				}
			    		console.log(data);
			    		console.log(type);
	    			}
	    			switch (type) {
	    				case 'HUC':
	    					hucTable(e, data, region);
	    					getCityCandidate(e, type, part);
	    				break;
	    				case 'PROVINCE':
	    					districtTable(e, data);
	    					getProvinceCandidate(e, type, part);
	    				break;
	    				case 'CITY':
	    					cityTable(e, data, name);
	    					getCityCandidate(e, type, part);
	    				break;
	    			}
	    			//loadTable(e, data);
		    		console.log(data);
				    console.log(type);
	    		}
	    		$('#locationModal').html(name);
	    		$('.screenLocation').html(name);
	    	}
		});
	}
});