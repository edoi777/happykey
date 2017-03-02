<?
if(empty($URIa[4])) {
?>
<h1>Управление ботом <div id="bot_status_module" class="label label-default">Unknown</div></h1>

<div class="" style="margin-top:20px">
			<div class="modal-header">
				<h4 class="modal-title" style="background:url('/admin/img/bot24.png') no-repeat left center;padding-left:32px;">Управление ботом</h4>
			</div>
			<div class="" style="border-top:0;">
				<button type="button" id="bot_start" class="btn btn-success"><img src="/admin/img/bot_run.png" alt=""/> Запустить</button>
				<button type="button" id="bot_stop" class="btn btn-danger"><img src="/admin/img/bot_shutdown.png" alt=""/> Остановить</button>
				<button type="button" id="bot_restart" class="btn btn-primary"><img src="/admin/img/bot_restart.png" alt=""/> Перезапуск</button>
			</div>
</div>
<?

} ?>
