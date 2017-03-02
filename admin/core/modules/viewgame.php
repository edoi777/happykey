<?php
function sortArrBy($data, $by)
{
		usort($data, function($first, $second) use( $by ) { 
		$first->$by = isset($first->$by) ? $first->$by : '0';
		$second->$by = isset($second->$by) ? $second->$by : '0';
		
		$first->$by = floatval($first->$by);
		$second->$by = floatval($second->$by);
		
		if ($first->$by > $second->$by) { return 1; } 
		elseif ($first->$by < $second->$by) { return -1; } 
		return 0; 
		});
		return $data;
}
?>

<h1>Игра <?=$URIa[3]?></h1>
<?php

$Item = $db->getRow('SELECT h.*, u.nickname, u.steamid, u.img FROM histories h, users u WHERE u.id = h.user_id AND h.id = '.$URIa[3]); 

$rates = $db->getRows('SELECT g.*, u.steamid as uid, u.nickname, u.img as uimg FROM gamelog g, users u WHERE u.steamid = g.steamid AND status = 1 AND processed = 1 AND g.gameid = '.$URIa[3]); 

$winitems = json_decode($Item['items']);
$rates_list = array();
$img = array();
$temp = json_decode($Item['items']);
foreach($temp as $k => $v){
	$img[md5($v->name)] = $v->img;
}
$all_sum = 0;
foreach($rates as $key => $values){
	if(empty($Item['points_round'])){
		
		if($values['firstuser'] == 1){
			$all_sum += $values['sum']*1.1;
		}else{
			$all_sum += $values['sum'];
		}
	}else{
		
		$all_sum = $Item['points_round'];
	}
	$rates_list[$values['steamid']]['user'] = $values['nickname'];
	$rates_list[$values['steamid']]['firstuser'] = $values['firstuser'];
	$rates_list[$values['steamid']]['uid'] = $values['uid'];
	$rates_list[$values['steamid']]['img'] = $values['uimg'];
	$rates_list[$values['steamid']]['sum'] = $values['sum']+(empty($rates_list[$values['steamid']]['sum'])? 0: $rates_list[$values['steamid']]['sum']);
	$rates_list[$values['steamid']]['item'][$values['id']] = $values;
}

?>

<div class="list">
	<div class="list_block history_block" style="<?=(($Item['status']==1)?'border-color:lime':'')?>">
		<div class="history_block_header">
			<div style="float:right"><?=$Item['created_at']?></div>
			<table style="margin-bottom:8px;">
				<tr>
					<td style="width:120px;">ИГРА</td>
					<td>
						<span class="label label-warning">№<?=$Item['id']?></span> 
					</td>
				</tr>
				<tr>
					<td>Победитель:</td>
					<td>
						<span class="label label-success"><?=$Item['nickname']?></span> 
						<a class="btn btn-xs btn-success" target="_blank" href="https://steamcommunity.com/profiles/<?=$Item['steamid']?>"><?=$Item['steamid']?></a>
					</td>
				</tr>
				<tr>
					<td>Выигрыш:</td>
					<td><span class="label label-primary"><?=$Item['sum']?> $</span></td>
				</tr>
				<tr>
					<td>Шанс:</td>
					<td><span class="label label-default"><?=$Item['chance']?>%</span></td>
				</tr>
				<tr>
					<td>Статус приза:</td>
					<td><span class="label label-<?=($Item['prize_status'] == 1?"success":"default")?>"><?=($Item['prize_status'] == 1?"Отправлен":"Не отправлен")?></span></td>
				</tr>
			</table>
		</div>
		<div class="history_block_content">
			<div class="items">
			<?foreach($winitems as $item):?>
				<div class="item">
					<div class="item-title"><?=$item->name?></div>
					<div class="image">
						<div class="caption"><span class="itemPrice"><?=$item->price?></span> $</div>
						<div class="image_cont" style="background-image:url('<?=($item->chips == 0?"http://cdn.steamcommunity.com/economy/image/":"http://".$ini['SYSTEM']['host']).''.$item->img?>');"></div>
					</div>
				</div>
			<?endforeach;?>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	
	
	
	
	

	<?foreach($rates_list as $Item):?>
	<div class="list_block history_block">
		<div class="history_block_header">
			<table style="margin-bottom:8px;">
				<tr>
					<td>Игрок:</td>
					<td>
						<span class="label label-success"><?=$Item['user']?></span> 
						<a class="btn btn-xs btn-success" target="_blank" href="https://steamcommunity.com/profiles/<?=$Item['uid']?>"><?=$Item['uid']?></a>
					</td>
				</tr>
				<tr>
					<td>Взнос:</td>
					<td><span class="label label-primary"><?=$Item['sum']?> $</span></td>
				</tr>
				<tr>
					<td>Шанс:</td>
					<td><span class="label label-default"><?=round((100/($all_sum)) * ($Item['sum']*($Item['firstuser']?1.1:1)), 2)?> %</span></td>
				</tr>
			</table>
		</div>
		<div class="history_block_content">
			<div class="items">
			<?foreach($Item['item'] as $item):?>
				<div class="item">
					<div class="item-title"><?=$item['item']?></div>
					<div class="image">
						<div class="caption"><span class="itemPrice"><?=$item['sum']?></span> $</div>
						<div class="image_cont" style="background-image:url('<?=($item['chips'] == 0?"http://cdn.steamcommunity.com/economy/image/":"http://".$ini['SYSTEM']['host']).''.$item['img']?>');"></div>
					</div>
				</div>
			<?endforeach;?>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?endforeach;?>
	
</div>

