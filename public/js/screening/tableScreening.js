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

    $('#tableGeo').DataTable( {
    	"bLengthChange": false,
    	"bInfo": false,
    	"ordering": false,
    	"searching": false,
    	"pageLength": 20,
    	"paging": false
    });

	$('#tableGeo').delegate('tbody > tr', 'mouseenter', function () {
		$(this).css({'font-weight': 'bold',
					'cursor': 'pointer'});
	});

	$('#tableGeo').delegate('tbody > tr', 'mouseleave', function () {
		$(this).css('font-weight', 'normal');
	});
		
});

function loadTable(data) {
	var keys = Object.keys(data);
	var y = keys.length - 1;
	console.log(data);
	$('tbody').html('');
	for (var x=keys[0]; x <= keys[y]; x++) {
		$('tbody').append(`
				<tr>
					<td class="code">` + data[x].code + `</td>
					<td class="description">` + data[x].description + `</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
			`);
	}

}

function ajaxGet(e, name) {
	$.ajax({
		method: 'GET',
		url: '/screening/' + e,
		success:function(data)  
    	{
    		console.log(data);
    		if (data == '') {
    		} else  {
    			if (name != undefined) {
    				$('.bcrumbs').append('<p>/</p> <a href="" id="' + e + '">' + name + '</a>');
    			}
    			loadTable(data);
    		}
    	} 
	});
}