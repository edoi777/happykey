<?php if(empty($URIa[4])) {?>
<script type="text/javascript" src="/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox.css?v=2.1.5" media="screen" />
<script>
$(document).ready(function() {
	$('.fancybox').fancybox({
		openEffect  : 'none',
		closeEffect	: 'none'
	});
});
</script>
<h1>Поддержка</h1>
<?php
$q = $db->getRows('SELECT *, (SELECT name FROM users WHERE steam = support.steamid LIMIT 1) as nickname, (SELECT link FROM users WHERE steam = support.steamid LIMIT 1) as link FROM support ORDER BY date DESC LIMIT 50');
echo '<table style="margin-top:20px;" class="table table-striped"><tr>
<th>Ник пользователя</th><th>Почта</th><th>Проблема</th><th>Скриншоты</th><th>Дата</th><th>Действия</th>
</tr>';
foreach($q as $line) {
	echo '<tr>
	<td><a href="http://steamcommunity.com/profiles/'.$line['steamid'].'">'.$line['nickname'].'</a></td>
	<td>'.$line['email'].'</td>
	<td>'.nl2br($line['content']).'</td>
	<td class="screens">';
if(!empty($line['scr1']))
echo '<a href="'.$line['scr1'].'" target="_blank" class="fancybox">Screen1</a>';
if(!empty($line['scr2']))
echo '<a href="'.$line['scr2'].'" target="_blank" class="fancybox">Screen2</a>';
if(!empty($line['scr3']))
echo '<a href="'.$line['scr3'].'" target="_blank" class="fancybox">Screen3</a>';
echo '</td>
<td>'.date('H:i:s - d.m.y', $line['date']).'</td>
<td>
<div class="btn-group btn-group-xs">
<a class="btn btn-primary btn-xs" target="_blank" href="'.$line['link'].'">Offer</a>
<a class="btn btn-danger btn-xs" href="/admin/mod/support/del/'.$line['id'].'/'.$_SESSION['admin_token'].'">Удалить</a>
</div>
</td>
</tr>';
}
echo '</table>';
}
else if($URIa[4]=='del' && is_numeric($URIa[5])) {
	$db->deleteRow('DELETE FROM support WHERE id = ?', array($URIa[5]));
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/support');exit;
}
?>
