$(document).ready(function() {
	function bot_check() {
		$.get('/admin/ajax/bot/status/', function(data) {
			if(data=='true') {
				$('#bot_start').attr('disabled','disabled');
				$('#bot_stop').removeAttr('disabled');
				$('#bot_status_menu, #bot_status_module')
					.removeClass('label-default')
					.removeClass('label-danger')
					.addClass('label-success')
					.html('online');
			}else {
				$('#bot_stop').attr('disabled','disabled');
				$('#bot_start').removeAttr('disabled');
				$('#bot_status_menu, #bot_status_module')
					.removeClass('label-default')
					.removeClass('label-success')
					.addClass('label-danger')
					.html('offline');
			}
		});
	}
	bot_check();
	var checkbot = setInterval(function() {bot_check();},3000);
	
	
	$('#bot_start').click(function() {
		var id = $('input[name=select]:checked').val();
		$('#bot_start').attr('disabled','disabled');
		$('#bot_stop').attr('disabled','disabled');
		$('#bot_restart').attr('disabled','disabled');
		$.get('../ajax/bot/action/start/'+id,function(data) {
			$('#bot_stop').removeAttr('disabled');
			$('#bot_restart').removeAttr('disabled');
		});
	});
	$('#bot_stop').click(function() {
		var id = $('input[name=select]:checked').val();
		$('#bot_start').attr('disabled','disabled');
		$('#bot_stop').attr('disabled','disabled');
		$('#bot_restart').attr('disabled','disabled');
		$.get('../ajax/bot/action/stop/'+id,function(data) {
			$('#bot_start').removeAttr('disabled');	
			$('#bot_restart').removeAttr('disabled');	
		});
	});
	$('#bot_restart').click(function() {
		var id = $('input[name=select]:checked').val();
		$('#bot_start').attr('disabled','disabled');
		$('#bot_stop').attr('disabled','disabled');
		$('#bot_restart').attr('disabled','disabled');
		$.get('../ajax/bot/action/restart/'+id,function(data) {
			$('#bot_stop').removeAttr('disabled');
			$('#bot_restart').removeAttr('disabled');
		});
	});	
});




function updatebalance(id) {
	var balance = $('#balance_'+id).val();
	$.ajax({
		type: "POST",
		url: "../ajax/shop/updatebalance",
		data: {id:id, balance:balance},
		success: function (data){
			alert("OK!");
		},
		dataType: "json"
	});
}

function save(id) {
	var price = $('#price_'+id).val();
	$.ajax({
		type: "POST",
		url: "../ajax/shop/save_item",
		data: {id:id, price:price},
		success: function (data){
			alert("OK!");
		},
		dataType: "json"
	});
}
function setstatus(id) {
	$.ajax({
		type: "POST",
		url: "../ajax/shop/setstatus",
		data: {id:id},
		success: function (data){
			if(data.status == 1){
				$('#status_'+id).html('Убрать с витрины');
				$('#status_'+id).removeClass('btn-warning');
				$('#status_'+id).addClass('btn-danger');
			}
			
			if(data.status == 0){
				$('#status_'+id).html('Выставить');
				$('#status_'+id).addClass('btn-warning');
				$('#status_'+id).removeClass('btn-danger');
			}
			
			if(data.status == 2){
				alert("Предметов не осталось!");
			}
			
		},
		dataType: "json"
	});
}
