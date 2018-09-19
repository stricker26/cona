$(document).ready( function () {

    $('#tableGeo').delegate('tbody > tr', 'click', function () {
    	var e = $(this).find(".code").html();
    	var name = $(this).find(".description").html();
    	var type = $(this).find(".type").html();
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
	});

	$('.bcrumbs').on('click', 'a', function(e) {
		e.preventDefault();
		var code = $(this).attr('id');
		var type = $(this).attr('class');
		console.log('Type: ' + type);
		$(this).nextAll().remove();
		if (code == 'regionNum') {
			location.reload();
		} else {
			ajaxGet(code, '', type);
			if (type == 'PROVINCE') {
				ajaxGet(code, '', 'CITY');
			}
			
		}
	});

	$('#tableGeo').delegate('tbody > tr', 'mouseenter', function () {
		$(this).addClass('table-hover');
	});

	$('#tableGeo').delegate('tbody > tr', 'mouseleave', function () {
		$(this).removeClass('table-hover');
	});

	$('th').click(function() {
		if ($(this).children('i').hasClass('x')) {
			if ($(this).children('i').hasClass('fa-sort-amount-asc')) {
				$(this).children('i').removeClass('fa-sort-amount-asc');
				$(this).children('i').addClass('fa-sort-amount-desc');
			} else {
				$(this).children('i').removeClass('fa-sort-amount-desc');
				$(this).children('i').addClass('fa-sort-amount-asc');
			}
		}
		$(this).children('i').addClass('x');
		$(this).siblings().children('i').removeClass('x');
		$(this).siblings().children('i').removeClass('fa-sort-amount-desc');
		$(this).siblings().children('i').addClass('fa-sort-amount-asc');
	});

	loadPagination();

	function loadTable(e, data) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		$('tbody').html('');
		for (var x = s; x <= d; x++) {
			console.log('key[x]: ' + x);
			$('tbody').append(`
					<tr class='item'>
						<td class="code">` + data[x].province_code + `</td>
						<td class="description">` + data[x].lgu + `</td>
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

	function ajaxGet(e, name, type) {
		if (type == null || type == undefined || type == '') {
			$.ajax({
				method: 'GET',
				url: '/screening/' + e,
				success:function(data)  
		    	{
		    		if (data == '') {
		    		}
		    		else  {
		    			if (name != undefined && name != '') {
		    				$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '" class="">' + name + '</a>');
		    			}
		    			loadTable(e, data);
		    		}
		    	} 
			});
		}
		else {
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
		    				case 'MUNICIPALITY':
		    					municipalityTable(e, data, name);
		    				break;
		    				case 'CITY':
		    					cityTable(e, data, name);
		    				break;
		    			}
		    			//loadTable(e, data);
		    		}
		    	} 
			});
		}
	}

	function hucTable(e, data) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		$('tbody').html('');
		for (var x=s; x <= d; x++) {
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

	function municipalityTable(e, data, name) {
		var keys = Object.keys(data);
		var y = keys.length - 1;
		var s = parseInt(keys[0]);
		var d = parseInt(keys[y]);
		$('tbody').html('');
		for (var x=s; x <= d; x++) {
			if (data[x].district == name) {
				$('tbody').append(`
						<tr class='item'>
							<td class="code">` + data[x].province_code + `</td>
							<td class="description">` + data[x].municipality + `</td>
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

});

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

function searchData() {
	// Declare variables 
	var input, filter, table, tr, td, i;
	input = document.getElementById("searchBar");
  	filter = input.value.toUpperCase();
  	table = document.getElementById("tableGeo");
  	tr = table.getElementsByTagName("tr");

  	// Loop through all table rows, and hide those who don't match the search query
  	for (i = 0; i < tr.length; i++) {
    	td1 = tr[i].getElementsByTagName("td")[0];
    	td2 = tr[i].getElementsByTagName("td")[1];
    	td5 = tr[i].getElementsByTagName("td")[5];
    	if (td1 || td2 || td5) {
      		if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 || td5.innerHTML.toUpperCase().indexOf(filter) > -1) {
        		tr[i].style.display = "";
      		} else {
        		tr[i].style.display = "none";
      		}
    	}
  	}
}

function loadPagination() {
    var rowsShown = 10;
    var rowsTotal = $('#tableGeo tbody tr').length;
    var numPages = rowsTotal/rowsShown;
    $('#nav').html('');
    for(i = 0;i < numPages;i++) {
        var pageNum = i + 1;
        $('#nav').append('<a href="#" rel="'+i+'">'+pageNum+'</a> ');
    }
    $('#tableGeo tbody tr').hide();
    $('#tableGeo tbody tr').slice(0, rowsShown).show();
    $('#nav a:first').addClass('active');
    $('#nav a').bind('click', function(){
        $('#nav a').removeClass('active');
        $(this).addClass('active');
        var currPage = $(this).attr('rel');
        var startItem = currPage * rowsShown;
        var endItem = startItem + rowsShown;
        $('#tableGeo tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
        css('display','table-row').animate({opacity:1}, 300);
        return false;
    });
}