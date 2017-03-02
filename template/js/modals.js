$( document ).ready(function() {

	
	$("#pay_button").click(function(){
		console.log('Открыть модалку оплаты');
		$("#addmoney").show();
	});	

	$('#close_pay').click(function() {
		$("#addmoney").hide();
    });
	
	////////////////////////////////////////////
	
	$('#warrning_low_money').click(function() {
		console.log('Открыть модалку мало денег');
		$("#low_money").show();
    });
	
	$('#pay_button_warrning').click(function() {
		console.log('Открыть модалку оплаты');
		$("#low_money").hide();
		$("#addmoney").show();
    });
	
	$('#close_warning').click(function() {
		$("#low_money").hide();
    });
	
	////////////////////////////////////////////
	
	$('#end_close').click(function() {
		location.reload();
    });
});