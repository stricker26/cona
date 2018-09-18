$(document).ready( function () {

    $('#tableGeo').delegate('tbody > tr', 'click', function () {
    	var e = $(this).find(".code").html();
    	var name = $(this).find(".description").html();
    	ajaxGet(e, name);
		
	});

	$('.bcrumbs').on('click', 'a', function(e) {
		e.preventDefault();
		var code = $(this).attr('id');
		$(this).nextAll().remove();
		if (code == 'regionNum') {
			location.reload();
		} else {
			ajaxGet(code);
		}
	});

	$('#tableGeo').delegate('tbody > tr', 'mouseenter', function () {
		$(this).css({'font-weight': 'bold',
					'cursor': 'pointer'});
	});

	$('#tableGeo').delegate('tbody > tr', 'mouseleave', function () {
		$(this).css('font-weight', 'normal');
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
		/*
		var y = keys.length - 1;
		var arr = [];
		var z = 0;
		console.log('length: ' + keys.length);
		for (var x=0; x < keys.length; x++) {
			z = keys[x];
			arr[x] = data[z];
		}
		arr.sort(SortByDescription);
		*/
		$('tbody').html('');
		for (var x=keys[0]; x <= keys[y]; x++) {
			$('tbody').append(`
					<tr class='item'>
						<td class="code">` + data[x].code + `</td>
						<td class="description">` + data[x].description + `</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>Lorem Ipsum</td>
					</tr>
				`);
			loadPagination();
		}
	}

	function ajaxGet(e, name) {
		$.ajax({
			method: 'GET',
			url: '/screening/' + e,
			success:function(data)  
	    	{
	    		if (data == '') {
	    		}
	    		else  {
	    			if (name != undefined) {
	    				$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '">' + name + '</a>');
	    			}
	    			loadTable(e, data);
	    		}
	    	} 
		});
	}
});

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
    });
}


/***
function SortByID(x,y) {
	return x.ID - y.ID; 
}

function SortByDescription(x,y) {
    return ((x.Description == y.Description) ? 0 : ((x.Description > y.Description) ? 1 : -1 ));
}
***/