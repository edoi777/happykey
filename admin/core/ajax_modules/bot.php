<?php
putenv("HOME=$bot_dir");

function bot_status() {
	exec("pgrep -a node", $out);
	if(count($out)>0){
		foreach($out as $v){
			$poss = strpos($v, 'bot.js');
			if($poss !== false){
				return true;
			}
		}
	}
	return false;
}
function bot_start($bot_dir,$admin_dir) {
	exec("forever start -m 1" .
			" -o $admin_dir/log/bot/nodebot_" . date('Y-m-d-H_i_S') . ".log" .
			" -e $admin_dir/log/bot/nodebot_" . date('Y-m-d-H_i_S') . ".log" .
			" -l $admin_dir/log/bot/nodebot_" . date('Y-m-d-H_i_S') . ".log" .
			" --workingDir $bot_dir" .
			" -p $bot_dir" .
			" ${bot_dir}bot.js 2>&1", $out);
var_dump($out);
	return true;
}
function bot_stop($bot_dir,$admin_dir) {
	exec("forever stop -p $bot_dir ${bot_dir}bot.js", $out);
	return true;
}
function shop_status() {
	exec("pgrep -lf node", $out);
	if(count($out)>0){
		foreach($out as $v){
			$poss = strpos($v, 'bot_shop.js');
			if($poss !== false){
				return true;
			}
		}
	}
	return false;
}
function shop_start($bot_dir,$admin_dir) {
	exec("forever start -m 1" .
			" -o $admin_dir/log/shop/nodebot_shop_" . date('Y-m-d-H_i_S') . ".log" .
			" -e $admin_dir/log/shop/nodebot_shop_" . date('Y-m-d-H_i_S') . ".log" .
			" -l $admin_dir/log/shop/nodebot_shop_" . date('Y-m-d-H_i_S') . ".log" .
			" --workingDir $bot_dir" .
			" -p $bot_dir" .
			" ${bot_dir}bot_shop.js", $out);
	return true;
}
function shop_stop($bot_dir,$admin_dir) {
	exec("forever stop $bot_dir ${bot_dir}bot_shop.js", $out);
	return false;
}

if($URIa[4]=='status') {
	// GET STATUS
	if(bot_status()) exit('true');
	else exit('false');
}
if($URIa[3]=='shop_status') {
	// GET STATUS
	if(shop_status()) exit('true');
	else exit('false');
}
else if($URIa[4]=='action') {

	
	// SET STATUS	
	if($URIa[5]=='start') {
		set_time_limit(4);
		if(!bot_status()) {
			bot_start($bot_dir,$admin_dir); 
			echo 'starting';
		}
		else {
			bot_stop($bot_dir,$admin_dir);
			bot_start($bot_dir,$admin_dir); 
			echo 'running';
		}
	}
	else if($URIa[5]=='stop') {
		bot_stop($bot_dir,$admin_dir);
		echo 'stopping';
	}
	else if($URIa[5]=='restart') {
		if(!bot_status()) {
			bot_start($bot_dir,$admin_dir); 
			echo 'restart';
		}
		else {
			if(bot_stop($bot_dir,$admin_dir)) 
			bot_start($bot_dir,$admin_dir);
			echo 'restart';
		}
	}
}

else if($URIa[4]=='log') {
	function log_color_parse($line) {
		preg_match_all('/\[([0-9]{2})m/',$line,$matches);
		foreach($matches[0] as $key=>$match) {
			$line = str_replace($match, '<span class="color'.$matches[1][$key].'">', $line);
			$line.='</span>';
		}
		$line = str_replace('[0m','</span><span>',$line);
		return $line;
	}
    $file = getLastFile($admin_dir.'log/bot');
	echo $admin_dir.'log/bot'.$file;
	$log = file_get_contents($admin_dir.'log/bot/'.$file);
	$log = explode("\n",$log);
	foreach($log as $key=>$line) {
		if(!empty($line)) echo "<div>".log_color_parse(htmlspecialchars($line))."</div>";
	}
}
else if($URIa[3]=='shop_log') {
	function log_color_parse($line) {
		preg_match_all('/\[([0-9]{2})m/',$line,$matches);
		foreach($matches[0] as $key=>$match) {
			$line = str_replace($match, '<span class="color'.$matches[1][$key].'">', $line);
			$line.='</span>';
		}
		$line = str_replace('[0m','</span><span>',$line);
		return $line;
	}
    $file = getLastFile($admin_dir.'log/shop');
	echo $admin_dir.'log/shop/'.$file;
	$log = file_get_contents($admin_dir.'log/shop/'.$file);
	$log = explode("\n",$log);
	foreach($log as $key=>$line) {
		if(!empty($line)) echo "<div>".log_color_parse(htmlspecialchars($line))."</div>";
	}
}
else if($URIa[3]=='price_update') {
	if(!empty($ini['SYSTEM']['analyst_api_key'])){
		if( $curl = curl_init() ) {
			curl_setopt($curl, CURLOPT_URL, 'https://api.csgofast.com/price/all');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,4);
			$out = curl_exec($curl);
			curl_close($curl);
		}
		$price = json_decode($out,true);
		if(!empty($price)){
			foreach($price as $key => $v){
				
				$db->updateRow('UPDATE items SET price = ? WHERE market_name = ? ', array($v, $key));
				/*$db->updateRow('INSERT INTO analyst SET market_name	= ?, link = ?, current_price = ?, current_price_last_checked = ?, avg_volume = ? 
								ON DUPLICATE KEY UPDATE market_name	= ?, link = ?, current_price = ?, current_price_last_checked = ?, avg_volume = ?', 
								array($v['market_name'], $v['link'], $sum, $v['current_price_last_checked'], $v['avg_volume'],$v['market_name'], $v['link'], $sum, $v['current_price_last_checked'], $v['avg_volume']));*/
				
			}
		}
		
	}else{
		$Items = $db->getRows('SELECT * FROM items');
		
		if($Items){
			foreach($Items as $Item){
				if( $curl = curl_init() ) {
					curl_setopt($curl, CURLOPT_URL, 'http://steamcommunity.com/market/priceoverview/?country=US&currency=1&appid=730&market_hash_name='.urlencode($Item['market_hash_name']));
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,4);
					$out = curl_exec($curl);
					curl_close($curl);
				}
				$sum = 0;
				$lowest_price = json_decode($out,true);
				if(!empty($lowest_price['lowest_price'])){
					$sum = str_replace('$', '', $lowest_price['lowest_price']);
				}
				
				$db->updateRow('UPDATE items SET price = ? WHERE market_hash_name = ? ', array($sum, $Item['market_hash_name']));
			}
		}
	}
}
function getLastFile($dir) {
        $files = array();
        $yesDir = opendir($dir); // открываем директорию
 
        if (!$yesDir) return false;
 
        // идем по элементам директории
        while (false !== ($filename = readdir($yesDir))) {
            // пропускаем вложенные папки
            if ($filename == '.' || $filename == '..')
            continue;
 
            // получаем время последнего изменения файла, заносим в массивы
            $lastModified = filemtime("$dir/$filename");
            $lm[] = $lastModified;
            $fn[] = $filename;
        }
 
        // сортируем массивы имен файлов и времен изменения по возрастанию последнего
        $files = array_multisort($lm,SORT_NUMERIC,SORT_ASC,$fn);
        $last_index = count($lm)-1;
 
	return $fn[$last_index];	
}
 
?>
