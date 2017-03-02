<?php
$setting = array();
$row = $db->getRows('SELECT * FROM shop_setting');
foreach($row as $value){
	$setting[$value['name']]=$value['value'];
}
if($URIa[3]=='updatebalance') {
	$id = $_POST['id'];
	$balance = $_POST['balance'];
	$update = $db->updateRow('UPDATE users SET balance = ? WHERE steamid = ?', array($balance, $id));
	echo json_encode(array("ok"));
} 
else if($URIa[3]=='save_item') {
	$id = $_POST['id'];
	$price = $_POST['price'];
	$update = $db->updateRow('UPDATE shop_items SET price = ? WHERE classid = ?', array($price, $id));
	echo json_encode(array("ok"));
}
else if($URIa[3]=='setstatus') {
	$id = $_POST['id'];
	$temp = $db->getRow('SELECT * FROM shop_items WHERE status != 2 AND classid = ?', array($id));
	if($temp){
		if($temp['status'] == 1){
			$temp['status'] = 0;
		}elseif($temp['status'] == 0){ 
			$temp['status'] = 1;
		}
		$update = $db->updateRow('UPDATE shop_items SET status = ? WHERE status != 2 AND classid = ?', array($temp['status'], $id));
		echo json_encode(array("status" => $temp['status']));
	}else{
		echo json_encode(array("status" => 2));
	}
}
else if($URIa[3]=='shop_update') {
	$old = array();
	$duble = array();
	$db->deleteRow('DELETE FROM shop_items');
	
	$out = get_url('https://steamcommunity.com/profiles/'.$setting['bot_steamid'].'/inventory/json/730/2/');
	$list = json_decode($out,true);
	$items = array();
	$class = array();
	$count = 0;
	$query = '';
	if($list['success'] == true){
		foreach($list['rgInventory'] as $value){
			if(empty($old[$value['id']])){
				$items[$value['id']]['classid'] = $value['classid'];
				$query .= "&classid".$count."=".$value['classid'];
				$count++;
			}else{
				$duble[$value['id']] = true;
			}
		}
		foreach($old as $key => $value){
			if(empty($duble[$key]) AND $value['status'] != 2){ 
				$db->deleteRow('DELETE FROM shop_items WHERE itemid = ?', array($key));
			}
		}
		if($count > 0){
			$out = get_url('https://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v1/?key='.$setting['bot_api'].'&format=json&appid=730&language=ru-RU&class_count='.$count.$query);
			$list = json_decode($out,true);
			if($list['result']['success'] == true){
				foreach($list['result'] as $key => $value){
					if($key != "success"){
						$class[$key]['name'] = $value['name'];
						$class[$key]['market_hash_name'] = $value['market_hash_name'];
						$class[$key]['img'] = $value['icon_url'];
						$class[$key]['type'] = '';
						$class[$key]['quality'] = '';
						$class[$key]['rare'] = '';
						$class[$key]['rarecolor'] = '';
						$class[$key]['exterior'] = '';
						foreach($value['tags'] as $val){
							if($val['category'] == "Type"){
								$class[$key]['type'] = $val['name'];
							}
							if($val['category'] == "Quality"){
								$class[$key]['quality'] = $val['name'];
							}
							if($val['category'] == "Rarity"){
								$class[$key]['rare'] = $val['name'];
								$class[$key]['rarecolor'] = $val['color'];
							}
							if($val['category'] == "Exterior"){
								$class[$key]['exterior'] = $val['name'];
							}
						}
					}
				}
				
				foreach($items as $key => $item){
					$price = 0;
					$steam_price = 0;
					
					$analist = $db->getRow('SELECT * FROM items WHERE market_name = ?', array($class[$item['classid']]['market_hash_name']));
					if($analist){
						$steam_price = $analist['price'];
						$price = $steam_price - (($steam_price/100)*$setting['default_price']);
					}else{
						$out = get_url('http://steamcommunity.com/market/priceoverview/?country=US&currency=1&appid=730&market_hash_name='.urlencode($class[$item['classid']]['market_hash_name']));
						$lowest_price = json_decode($out,true);
						$steam_price = str_replace('$', '', $lowest_price['lowest_price']);
						$price = $steam_price - (($steam_price/100)*$setting['default_price']);
					}
					
					
					$db->insertRow('INSERT INTO shop_items SET 
							itemid = ?, 
							classid = ?, 
							name = ?, 
							exterior = ?, 
							img = ?, 
							price = ?, 
							steam_price = ?, 
							type = ?, 
							rare = ?, 
							rarecolor = ?, 
							quality = ?, 
							status = ?', 
					array(
							$key, 
							$item['classid'], 
							$class[$item['classid']]['name'], 
							$class[$item['classid']]['exterior'], 
							$class[$item['classid']]['img'], 
							$price, 
							$steam_price, 
							$class[$item['classid']]['type'], 
							$class[$item['classid']]['rare'], 
							$class[$item['classid']]['rarecolor'], 
							$class[$item['classid']]['quality'], 
							$setting['add_showcase']
					));
				}
				
			}
		}
	}
}


function get_url ($url){
	if( $curl = curl_init() ) {
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,4);
		$out = curl_exec($curl);
		curl_close($curl);
	}
	return $out;
}
?>
