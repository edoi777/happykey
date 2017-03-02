<h1>История игр (отображены последние 50 игр)</h1>
<?php
if(!empty($_POST['q'])) {
	$_POST['q']='%'.$_POST['q'].'%';
	$WHERE = ' WHERE id LIKE ? OR (SELECT steamid FROM users WHERE users.id = histories.user_id LIMIT 1) LIKE ? OR (SELECT nickname FROM users WHERE users.id = histories.user_id LIMIT 1) LIKE ? AND status = 1';
	$WHERE_ARR = array($_POST['q'],$_POST['q'],$_POST['q']);
}
else {
	$WHERE = ' WHERE status = 1';
	$WHERE_ARR = array();
}
$rows = $db->getRows('SELECT *, (SELECT nickname FROM users WHERE users.id = histories.user_id LIMIT 1) as nickname, (SELECT steamid FROM users WHERE users.id = histories.user_id LIMIT 1) as steamid FROM histories'.$WHERE.' ORDER BY id DESC LIMIT 30',$WHERE_ARR);
if(!$rows) echo $db->error;
echo '<div class="list">';
foreach($rows as $row) {
	echo '<div class="list_block history_block" style="'.(($row['status']==1)?'border-color:lime':'').'">
		<div class="history_block_header"><div style="float:right">'.$row['created_at'].'</div><table style="margin-bottom:8px;"><tr><td style="width:120px;">ИГРА</td><td><span class="label label-warning">№'.$row['id'].'</span> <a class="btn btn-xs btn-success" target="_blank" href="/mod/viewgame/'.$row['id'].'">ПОДРОБНЕЕ</a></td></tr><tr><td>Победитель:</td><td><span class="label label-success">'.$row['nickname'].'</span> <a class="btn btn-xs btn-success" target="_blank" href="https://steamcommunity.com/profiles/'.$row['steamid'].'">'.$row['steamid'].'</a></td></tr><tr><td>Выигрыш:</td><td><span class="label label-primary">'.$row['sum'].' $</span></td></tr><tr><td>Шанс:</td><td><span class="label label-default">'.$row['chance'].'%</span></td></tr><tr><td>Статус приза:</td><td><span class="label label-'.($Item['prize_status'] == 1?"success":"default").'">'.($row['prize_status'] == 1?"Отправлен":"Не отправлен").'</span></td></tr></table></div>
		<div class="history_block_content">';
	$items = json_decode($row['items']);
	echo '<div class="items">';
	$sorted_items = array();
	foreach($items as $item) {
		$key=$item->price*100;
		do {
			$key = (int)$key+1;
		} while (array_key_exists($key,$sorted_items));
		$sorted_items[$key] = $item;
	}
	ksort($sorted_items);
	$sorted_items = array_reverse($sorted_items);
	
	foreach($sorted_items as $item) {
		echo '<div class="item"><div class="item-title">'.$item->name.' (~$'.$item->price.') </div><div class="image"><div class="caption"><span class="itemPrice">'.$item->price.'</span> $</div><div class="image_cont" style="background-image:url(\''.($item->chips == 0?"http://cdn.steamcommunity.com/economy/image/":"http://".$ini['SYSTEM']['host']).''.$item->img.'\');"></div></div></div>';
	}
	echo '</div>';
	echo '<div style="clear:both;"></div></div>
	</div>';
}
echo '</div>';
?><script>
$(document).ready(function() {
	$('#search_form input,#search_form button').removeAttr('disabled');
});
</script>
