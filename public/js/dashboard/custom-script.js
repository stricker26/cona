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
		$('#left-panel #statusCandidates #statusData').val(value);
		$('#left-panel #statusCandidates').submit();
	});
	//regional and provincial
	$('#left-panel #main-menu .dropdown-menu li .reg-stat span').on('click', function(){
		var value = $(this).data("value");
		$('#left-panel #statusCandidates #statusData').val(value);
		$('#left-panel #statusCandidates').submit();
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
		if (path == '/' + part + '/screening') {
			if (type == 'DISTRICT') {
				ajaxGet(e, name, 'MUNICIPALITY', undefined, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else if (type == 'PROVINCE') {
	    		ajaxGet(e, name, type, region, part);
	    		ajaxGet(e, name, 'HUCs', region, part);
	    		ajaxGet(e, name, 'CITY', region, part);
	    		getProvinceCandidate(e, type, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').hide(500);
	    		$('.gov-governor').show(500);
    			$('.gov-districts').hide(500);
	    	}
	    	else if (type == 'ICC') {
	    		ajaxGet(e, name, type, region, part);
	    		getCityCandidate(e, type, part, name, region);
	    		$('#locationModal').html(name);
	    		$('.screenLocation').html(name);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('#cc-councilor-wrapper').show(500);
	    		$('.gov-governor').hide(500);
	    		$('.gov-districts').hide(500);
	    		$('.huc-districts').hide(500);
	    		$('.prov-districts').hide(500);
	    	}
	    	else {
	    		ajaxGet(e, name, type, region, part);
	    		$('.list-candidates').show();
	    		$('.gov-mayor').show(500);
	    		$('.gov-governor').hide(500);
    			$('.gov-districts').hide(500);
    			if(type != 'HUC DISTRICT' && region != 'NCR') {
	    			$('#cc-councilor-wrapper').show(500);
	    		} else {
	    			$('#cc-councilor-wrapper').hide(500);
	    		}
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

	if (path == '/'+part+'/screening/profile') {
	}

	function ajaxGet(e, name, type, region, part) {
		$.ajax({
			method: 'GET',
			url: '/' + part + '/screening/' + type + '/' + e,
			success:function(data)  
	    	{
	    		if (data == '') {
	    			if (type == 'PROVINCE' || (type == 'HUC' && region == 'NCR') || type == 'ICC') {
						$('.bcrumbs').html('<a href="" id="' + region + '" class="REGION">REGION ' + region + '</a> <p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
					}
	    		}
	    		else  {
	    			if (name != undefined && name != '') {
	    				if (type != 'CITY') {
	    					if (type == 'PROVINCE' || (type == 'HUC' && region == 'NCR')) {
		    					$('.bcrumbs').html('<a href="" id="' + region + '" class="REGION">REGION ' + region + '</a> <p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');				
		    				}
		    				else {
		    					if ($('#' + e).length == 0) {
		    						$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
		    					}
		    				}
	    				}
	    			}
	    			switch (type) {
	    				case 'HUCs':
	    					hucTable(e, data, region);
	    					getCityCandidate(e, type, part, name, region);
	    				break;
	    				case 'HUC':
	    					hucTable(e, data, region);
	    					getCityCandidate(e, type, part, name, region);
	    				break;
	    				case 'PROVINCE':
	    					districtTable(e, data);
	    					getProvinceCandidate(e, type, part, name, region);
	    				break;
	    				case 'CITY':
	    					cityTable(e, data, name);
	    					getCityCandidate(e, type, part, name, region);
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