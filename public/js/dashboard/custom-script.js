var path = window.location.pathname;
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
		var data = dataProvince.split(',');
		var e = data[0];
		var name = data[2];
		var type = data[1];
		if (path == '/screening') {
			if (type == 'DISTRICT') {
	    		ajaxGet(e, name, 'MUNICIPALITY');
	    	}
	    	else if (type == 'PROVINCE') {
	    		ajaxGet(e, name, type);
	    		ajaxGet(e, name, 'CITY');
	    	}
	    	else {
	    		ajaxGet(e, name, type);
	    	}
	    	$('html, body').animate({
		        scrollTop: $("#tableGeo").offset().top
		    }, 1000);
	    }
	    else {
	    	window.location.href = '/screening?e=' + e + '&name=' + name + '&type=' + type ;
	    }
	});

	function ajaxGet(e, name, type) {
		$.ajax({
			method: 'GET',
			url: '/screening/' + type + '/' + e,
			success:function(data)  
	    	{
	    		console.log(data);
	    		if (data == '') {
	    		}
	    		else  {
	    			if (name != undefined && name != '') {
	    				if (type != 'CITY') {
	    					$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '" class="' + type + '">' + name + '</a>');
	    				}
	    			}
	    			switch (type) {
	    				case 'HUC':
	    					hucTable(e, data);
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

	function hucTable(e, data) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		$('tbody').html('');
		for (var x=s; x <= d; x++) {
			if (data[x].district == '') {
				$('tbody').append(`
						<tr class='item'>
							<td class="code">` + data[x].province_code + `</td>
							<td class="description">` + data[x].city + `</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>Lorem Ipsum</td>
							<td class="type" style="display:none;">` + data[x].type + `</td>
						</tr>
				`);
				loadPagination();
			}
			else {
				$('tbody').append(`
						<tr class='item'>
							<td class="code">` + data[x].province_code + `</td>
							<td class="description">` + data[x].district + `</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>Lorem Ipsum</td>
							<td class="type" style="display:none;">` + data[x].type + `</td>
						</tr>
				`);
				loadPagination();
			}
		}
	}

	function districtTable(e, data) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		$('tbody').html('');
		for (var x=s; x <= d; x++) {
			if (x != keys[0]) {
				if (data[x].district != data[x-1].district) {
					printRow(data, x);
				}
			}
			else {
				printRow(data, x);
			}
		}
	}

	function cityTable(e, data, name) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		for (var x=s; x <= d; x++) {
			$('tbody').append(`
					<tr class='item'>
						<td class="code">` + data[x].province_code + `</td>
						<td class="description">` + data[x].city + `</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>Lorem Ipsum</td>
						<td class="type" style="display:none;">` + data[x].type + `</td>
					</tr>
			`);
			loadPagination();
		}
	}

	function printRow(data, x) {
	$('tbody').append(`
			<tr class='item'>
				<td class="code">` + data[x].province_code + `</td>
				<td class="description">` + data[x].district + `</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>Lorem Ipsum</td>
				<td class="type" style="display:none;">DISTRICT</td>
			</tr>
	`);
	loadPagination();
	}

});