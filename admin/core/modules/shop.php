
<h1>Витрина</h1>
<div class="" style="margin-top:20px">
			<div class="" style="border-top:0;">
				<button type="button" id="shop_update" class="btn btn-success"><img src="/img/bot_run.png" alt=""/>Загрузить инвентарь</button>
			</div>
</div>
<?
	$rows = $db->getRows('SELECT *, COUNT(*) as count FROM shop_items WHERE status != 2 GROUP BY classid');
?>
<table style="margin-top:20px;" class="table table-striped"><tr><th>ID</th><th>Изображение</th><th>Название</th><th>Цена</th><th>Наша цена</th><th>Колл.</th><th></th></tr>
<?foreach($rows as $row):?>
<tr>
	<td><?=$row['id']?></td>
	<td><img  width="100" src="http://cdn.steamcommunity.com/economy/image/<?=$row['img']?>"></td>
	<td><?=$row['name']?></td>
	<td><?=$row['steam_price']?> $</td>
	<td><input type="text" id="price_<?=$row['classid']?>" value="<?=$row['price']?>"> $</td>
	<td><?=$row['count']?></td>
	<td>
		<?if($row['status'] == 0):?>
		<a class="btn btn-warning btn-xs" href="#"  id="status_<?=$row['classid']?>" onclick="setstatus(<?=$row['classid']?>);return false;">
			Выставить
		</a> 
		<?else:?>
		<a class="btn btn-danger btn-xs" href="#" id="status_<?=$row['classid']?>" onclick="setstatus(<?=$row['classid']?>);return false;">
			Убрать с витрины
		</a>
		<?endif;?>
		<a class="btn btn-primary btn-xs" href="#"  onclick="save(<?=$row['classid']?>);return false;">
			Сохранить
		</a>
	</td>
</tr>
<?endforeach;?>
</table>