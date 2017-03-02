<h1>Логи бота</h1>
<div class="console" id="c"></div>
<script>
window.onload = function() {
	$('#c').load('../ajax/bot/log');
	logs = setInterval(function(){
$('#c').load('../ajax/bot/log');var objDiv = document.getElementById("c");
objDiv.scrollTop = objDiv.scrollHeight;
},2000);
};
</script>
