<?php
error_reporting(E_ALL & ~E_DEPRECATED);
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/pdo.php';
require $_SERVER["DOCUMENT_ROOT"] . '/core/db/db.php';
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';
$myConnect = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']); 
mysql_select_db($config['db']['base'],$myConnect);
$pdo = new DATABASE(
    "mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
    $config['db']['user'],
    $config['db']['pass']
);
function fetchinfo($rowname, $tablename, $finder, $findervalue){
	if ($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
	else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'") or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row[$rowname];
}
function onadmin(){
		if (isset($_SESSION['steamid'])){
			$admin = fetchinfo("admin", "users", "steam", $_SESSION["steamid"]);
			if($admin==1) return true;
			else return false;
		} else return false;
		
}
if(isset($_POST["action"])){
	$_POST["action"] = $_POST["action"];	
}else{
	$_POST["action"] = 0;
}
if(isset($_GET["action"])){
	$_GET["action"] = $_GET["action"];	
}else{
	$_GET["action"] = 0;
}



if (trim($_POST["action"]) == "activecode") {	
	if(isset($_SESSION['steamid'])){
	$steamid = $_SESSION['steamid'];
	$code = $_POST["codes"];
	$rs3 = mysql_query("SELECT * FROM `codes` WHERE `code`='$code' ORDER BY `price` DESC");
    if (mysql_num_rows($rs3) > 0) {
		$row = mysql_fetch_array($rs3);
		$money = $row['price'];
		$pdo->query("UPDATE `users` SET `money` = `money`+".$money." WHERE `steam`='{$steamid}'");
		mysql_query("DELETE FROM codes WHERE id='".$row['id']."'");
		echo'Успешно';
	}else echo'Код не найден';
	}else{
		echo 'Не авторизирован';
	}
}
if (trim($_POST["action"]) == "actpromo") {	
    $data = array();
    if (isset($_SESSION['steamid'])) {
        $steamid = $_SESSION['steamid'];
        $code = $_POST["promo"];
        $rs3 = mysql_query("SELECT * FROM `promo` WHERE `promo`='$code'");
        if (mysql_num_rows($rs3) > 0) {
            $row = mysql_fetch_array($rs3);
            $users = mysql_query("SELECT * FROM `users` WHERE `steam`='{$steamid}'");
            $selus = mysql_fetch_array($users);
            if (strlen($selus['promo']) > 2) {
                $data['status'] = false;
                $data['msg'] = 'Вы уже активировали промокод '.$selus['promo'].'';
            } else {
				$prom = mysql_query("SELECT * FROM `statspromo` WHERE `userid`='{$steamid}' AND `promo`= '{$code}'");
				if(mysql_num_rows($prom)>0){
					$data['status'] = false;
                    $data['msg'] = 'Вы уже активировали промокод '.$code.'!';
				}else {
					mysql_query("UPDATE `users` SET `promo` = '{$code}' WHERE `steam`='{$steamid}'");
                    $data['status'] = true;
                    $data['msg'] = 'Промокод успешно активирован!При пополнении счёта вы получите +'.$row['percent'].' % к пополнению!';
				}
					
                
            }
        } else {
            $data['status'] = false;
            $data['msg'] = 'Данный код не найден!';
        }
    } else {
        $data['status'] = false;
        $data['msg'] = 'Авторизируйтесь для дальнейших действий';
    }
    echo json_encode($data);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'год',
        'm' => 'месяц',
        'w' => 'неделю',
        'd' => 'день',
        'h' => 'час',
        'i' => 'минут',
        's' => 'секунд',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' назад' : 'сейчас';
}
if (isset($_GET["getwinners"])) {
		$fd = '';
		$last = $pdo->query("SELECT * FROM `last` ORDER BY `id` DESC limit 16");
		while ($row = $last->fetch()){
			
			$fd .= '
			
			<div class="win">
			          <div class="win_image" style="background: url('.$row['imgcase'].') no-repeat center center;background-size:cover"></div>
			          <a style="text-decoration: none;" href="http://steamcommunity.com/profiles/'.$row['userid'].'" target="_blank"><div class="nick">'.$row['username'].'</div></a>
			          <div class="ago">'.time_elapsed_string($row['last']).'</div>
		          </div>
		'; 
			
			
		}
		echo $fd;
}
if (trim($_POST["action"]) == "start") {
	    $data = array();
		if(isset($_SESSION['steamid'])){
			$steamid = $_SESSION['steamid'];
			$dataf = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$steamid}'");

	        $uprice = 69;
            $balance = $dataf['money'];
			if($balance>=$uprice){
				if($dataf['fake']=='1'){
			        $resf = $pdo->__fetch("SELECT * FROM `cases` WHERE `status`='1' ORDER BY rand() LIMIT 1");
		        }else{
			        $resf = $pdo->__fetch("SELECT * FROM `cases` WHERE `status`='0' ORDER BY rand() LIMIT 1");
		        }	
			    $selgame = $resf['name'];
		    	$game = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `game`='{$selgame}' ORDER BY rand() LIMIT 1");
				$name = $dataf['name'];
				$imgcase =  $resf['img'];
				$namecase = $resf['disp_name'];
				$itemsarr = array();
				$num1 = rand(111111, 999999);
	            $num2 = rand(111111, 999999);
	            $gamenum = $num1+$num2;		
                $date = date('Y-m-d H:i:s');
				$newbalance = $balance-$uprice;
				mysql_query("DELETE FROM itemsincases WHERE id='".$game['id']."'");
				$pdo->query("UPDATE `users` SET `money` = `money`-'{$uprice}',`spent` = `spent` + '$uprice',`cases` = `cases` + 1 WHERE `steam`='{$steamid}'");
                $pdo->query("INSERT INTO `last` (`username`, `userid`, `game`, `imgcase`,`key`,`last`) VALUES ('{$name}', '{$steamid}', '{$selgame}', '{$imgcase}', '{$game['key']}', '{$date}')");
				$data['status']=  'success';
				$data['name']=      $namecase;
				$data['img']=      $imgcase;
				$data['key']=      $game['key'];
                $data['game_id']=  $gamenum;
				$data['balance']=  $newbalance;

			}else{
				$data['status']=  'no_money';
				$data['money']=  $uprice-$balance;
			}
		}else{
			$data['status']=  'not_auth';
		}
    echo json_encode($data);
}

/*
	Сохранение ссылки
*/
if (trim($_POST["action"]) == "saveLink") {
    $link = $_POST['url'];
    $pdo->query("UPDATE `users` SET `link` = '$link' WHERE `steam`='{$_SESSION['steamid']}'");
}




if(trim($_GET["action"]) == "casein"){
	$data = array();
	$case = $_GET["caseid"];
	$resf = $pdo->query("SELECT * FROM `itemsincases` WHERE `case`='{$case}' ORDER BY `id` DESC");
	    while ($rows = $resf->fetch()) {
			$data[$rows["id"]]['id']=        $rows['id'];  
            $data[$rows["id"]]['img']=       $rows['img'];        
			$data[$rows["id"]]['name0']=     $rows['category'];
			$data[$rows["id"]]['name1']=     $rows['rusname'];
			$data[$rows["id"]]['quality']=   $rows['quality'];
			$data[$rows["id"]]['autobuy']=   $rows['autobuy'];
			$data[$rows["id"]]['openit']=   $rows['open'];
			$name = $rows['category'].' | '.$rows['name'];
			$resff = $pdo->__rows("SELECT * FROM `bot` WHERE `name`='{$name}'");
			$data[$rows["id"]]['count'] = $resff;
			
		}
    echo json_encode($data);
}
/*
	Продажа оружия
*/
if (trim($_POST["action"]) == "sellItem") {
    $ids = $_POST['ids'];
    $resf = $pdo->query("SELECT * FROM `itemsincases` WHERE `id`='{$ids}' ORDER BY `id` DESC");
    $price = fetchinfo("price", "inventory", "id", $ids);
	
    $data = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");
    $inventory = $pdo->__fetch("SELECT * FROM `inventory` WHERE `id`='{$ids}'");
    if (is_null($inventory)) {
    	echo '{"status":"error","msg":"itemerror"}';
    	exit;
    }
    if ($inventory['user'] != $_SESSION['id']) {
    	echo '{"status":"error","msg":"itemerror"}';
    	exit;
    }
    if ($inventory['status'] == 'selled' or $inventory['status'] == 'completed' or $inventory['status'] == 'send') {
    	echo '{"status":"error","msg":"itemerror"}';
    	exit;
    }
    $balance = $data['money'];
	$casersop = $data['cases'];
    $plus = $balance + $price;
    $res = '{
	"status":"suc",
	"price": ' . $price . ',
	"plus": ' . $plus . '
	}';
    $pdo->query("UPDATE `bot` SET `wait` = 0 WHERE `item_id`='{$inventory['item_id']}'");
    $pdo->query("UPDATE `users` SET `money` = '{$plus}' WHERE `steam`='{$_SESSION['steamid']}'");
    $pdo->query("UPDATE `inventory` SET `status` = 'selled' WHERE `id`='{$ids}' and `user`='{$_SESSION['id']}'");
    exit($res);
}
if (trim($_POST["action"]) == "loadscratc") {
	$datacards = array();
	$gamenum = $_POST["game_id"];
    $scratchid= $_POST['data'];
	$getgame = $pdo->__fetch("SELECT * FROM `games` WHERE `gamenum`='{$gamenum}'");
    if (is_null($getgame)) die('{"status":"error","msg":"Не найдена игра"}');
	
	$itemsarrs=$getgame['iteamsid'];
	$keywords = preg_split("/[\s,]+/", $itemsarrs);
	$shans=false;
	$win = false;
	$slot['0'] ='';
	$slot['1'] ='';
	$slot['2'] ='';
	for ($x = 0; $x < count($keywords); $x++) {
	   if (!empty($keywords[$x])) {
		$row = explode(":", $keywords[$x]);
		$datacards[$row[0]]= $row[1];
		$resf = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `case`='{$getgame['case']}' ORDER BY rand() LIMIT 1");
		$datacards[99+$x] = $resf['id'];
		$datacards[90+$x] = $resf['id'];
		$datacards[85+$x] = $resf['id'];
		$datacards[80+$x] = $resf['id'];
		$datacards[75+$x] = $resf['id'];
        $datacards[70+$x] = $resf['id'];
		$slot[$x] = $row[1];		
		if($x ==3){
			if($slot[1] == $slot[2] && $slot[2] == $slot[3]) $win= true;
			else $shans=true;		
		} 
		if($x >3) $win= true;
	   }
	}
	$cs = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `id`='{$datacards[$scratchid]}'");

	$case2 = $getgame['case'];
    $type = $cs['quality'];
    $firstName = $cs['category'];
    $secondName = $cs['rusname'];
    $fullName = $firstName . " | " . $secondName;
    $image = $cs['img'];
    $en = addslashes($cs['name']);
    $pricew = $cs['price'];
    $stattrack = false;
    $imgsock = 'https://steamcommunity-a.akamaihd.net/economy/image/' . $image;
    $engfullname = addslashes($firstName . ' | ' . $en);
	$data = array();
	$cases = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$case2}'");
	$imgcase =  $cases['img'];
	$zenashans =  $cases['shans'];
	if($win){
		$win = $pdo->__fetch("SELECT * FROM `games` WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
		if(empty($win['win']))	$pdo->query("UPDATE `games` SET `win`='{$datacards[$scratchid]}' WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
		else $rand_keysz = $win['win'];	
		$pdo->query("INSERT INTO `last` (`username`, `userid`, `casename`, `weapon`, `type`, `img`, `imgcase`) VALUES (\"{$_SESSION['name']}\", \"{$_SESSION['id']}\", \"{$case2}\", \"{$engfullname}\", \"{$type}\", \"{$image}\", \"{$imgcase}\")");
        $date = date('Y-m-d H:i:s');
		$pdo->query("INSERT INTO `inventory` (`weapon`, `second`, `seconden`, `type`, `img`, `price`, `case`, `user`, `status`, `datatime`) VALUES (\"{$firstName}\", \"{$secondName}\", \"{$en}\", '{$type}', \"{$image}\", '{$pricew}', '{$case2}', '{$_SESSION['id']}', 'progress', '{$date}')");
        $inventory_item_id = $pdo->lastInsertId();
	    $pdo->query("UPDATE `users` SET `profit` = `profit` + '$pricew' WHERE `id`='{$_SESSION['id']}'");
		$data['status']= 'win';
		for ($y = 1; $y < 10; $y++) {
			$namecase= 'case-'.$y;
			$num = array_rand ($datacards);
            if (!is_null($datacards[$namecase])) $iteamid=$datacards[$namecase];
			else $iteamid = $datacards[$num];
			$cs = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `id`='{$iteamid}'");
			$data['iteamid'] = $inventory_item_id;
            $data['case'][$namecase]['type'] = $cs['quality'];
			$data['case'][$namecase]['image'] = 'https://steamcommunity-a.akamaihd.net/economy/image/'.$cs['img'].'/125x125f';
			$data['case'][$namecase]['fullname'] = $cs['category'];
			$data['case'][$namecase]['spacename'] = $cs['rusname'];
		}
	} 
	else if($shans){
		$data['status']= 'shans';
		$data['shans']= $zenashans;
	} 
	else $data['status']= 'success';
	$data['case_id']=$scratchid;
	$data['weapon']['price']=        $pricew;  
	$data['weapon']['type']=        $type;  
    $data['weapon']['image']=        'https://steamcommunity-a.akamaihd.net/economy/image/'.$image .'/125x125f';        
	$data['weapon']['fullname']=      $firstName;
	$data['weapon']['spacename']=      $secondName;
    echo json_encode($data);
}
if (trim($_POST["action"]) == "shans") {
	$gamenum = $_POST["game_id"];
	$getgame = $pdo->__fetch("SELECT * FROM `games` WHERE `gamenum`='{$gamenum}'");
	if (is_null($getgame)) die('{"status":"error","msg":"Не найдена игра"}');
	$resf = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$getgame['case']}'");
	$uprice = $resf['shans'];  //Цена шанса
    $data = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");
	$casersop = $data['cases'];
    $balance = $data['money'];
    $fake = $data['fake'];
    if ($balance < $uprice) die('{"status":"error_balance","msg":"errbalance"}');    
	$pdo->query("UPDATE `users` SET `spent` = `spent` + '$uprice' WHERE `steam`='{$_SESSION['steamid']}'");
	$pdo->query("UPDATE `games` SET `chance`='1' WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
	echo '{"status":"on_shans","msg":"ok"}';	
}
if (trim($_POST["action"]) == "loadscratc_one") {
	if(isset($_SESSION['id'])){
	    $datacards = array();
	    $gamenum = $_POST["game_id"];
		$scratchid= $_POST['data'];

		$getgame = $pdo->__fetch("SELECT * FROM `games` WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
        if (is_null($getgame)) {
    	    die('{"status":"error","msg":"Не найдена игра"}');
        }
		$dataf = $pdo->__fetch("SELECT * FROM `users` WHERE `steam`='{$_SESSION['steamid']}'");
		if($dataf['fake']=='1'){
			$resf = $pdo->query("SELECT * FROM `itemsincases` WHERE `case`='{$getgame['case']}' AND `open`='1' ORDER BY rand()");
		}else{
			$resf = $pdo->query("SELECT * FROM `itemsincases` WHERE `case`='{$getgame['case']}' AND `open`='0' ORDER BY rand()");
		}
		
		$rese = $pdo->query("SELECT * FROM `bot` WHERE `wait`=0");
		$itemsarrs=$getgame['iteamsid'];
		$shans = false;
		$keywords = preg_split("/[\s,]+/", $itemsarrs);
	    for ($x = 0; $x < count($keywords); $x++) {
		    $row = explode(":", $keywords[$x]);
		    $datacards[$row[0]]= $row[1];
			if($x >=3) $shans=true;
	    }
		if($scratchid=="case-10" && !$shans){
			die('{"status":"error","msg":"hacker"}');
		}
		if($shans && $scratchid!="case-10" ){
			if($getgame['chance'] == 0) die('{"status":"error","msg":"hacker"}');
		}
		if(isset($datacards[$scratchid])) die('{"status":"error","msg":"slotnotempty"}');
		$itemscount=0;
	////////////////////////////////////		
	$i = 0;	
	while ($rows = $resf->fetch()) {
       	$itemsarr[$itemscount]=array(
			'id'	=>	$rows['id'],
			'name'		=>	$rows['category'] . ' | ' . $rows['name'],
		);
	    $itemscount++;
	}
    while ($row = $rese->fetch()) {
		 foreach ($itemsarr as $key => $rows) {
            $name_ff = $rows['name'];	
	        if($dataf['fake']=='1')	{	
                $rand_keys[$i] = $rows['id'];
			    $num = array_rand($datacards);
			    if(!is_null($datacards[$num])){
				    $rand_keys[$i+99] = $datacards[$num];
			    } 
                $i++;
                //break;
                if ($i > 5) break;
			}else{
				if ($row['name'] == $name_ff) {		
                    $rand_keys[$i] = $rows['id'];
				    $num = array_rand($datacards);
			        if(!is_null($datacards[$num])){
				        $rand_keys[$i+99] = $datacards[$num];
			        } 
                    $i++;
                    //break;
                    if ($i > 5) break;
                } 
			}		

        }
    }				
		
    if (empty($rand_keys)) {
        die('{"status":"error","msg":"notfoundweapon"}');
    }
    $num = array_rand ($rand_keys);
    $rand_keysz = $rand_keys[$num];

	$cs = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `id`='{$rand_keysz}'");
    $type = $cs['quality'];
    $firstName = $cs['category'];
    $secondName = $cs['rusname'];
    $fullName = $firstName . " | " . $secondName;
    $image = $cs['img'];
    $en = addslashes($cs['name']);
    $pricew = $cs['price'];
    $stattrack = false;
    $imgsock = 'https://steamcommunity-a.akamaihd.net/economy/image/' . $image;
    $engfullname = addslashes($firstName . ' | ' . $en);
	$itemsarrs = $itemsarrs .','.$scratchid.':'.$rand_keysz;
	$inventory_item_id = 0;
	if($scratchid=="case-10"){
		$win = $pdo->__fetch("SELECT * FROM `games` WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
		if(empty($win['win']))	$pdo->query("UPDATE `games` SET `win`='{$rand_keysz}' WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
		else $rand_keysz = $win['win'];
		$cs = $pdo->__fetch("SELECT * FROM `itemsincases` WHERE `id`='{$rand_keysz}'");
		$type = $cs['quality'];
        $firstName = $cs['category'];
        $secondName = $cs['rusname'];
        $image = $cs['img'];
		$case2 = $win['case'];
		$cases = $pdo->__fetch("SELECT img FROM `cases` WHERE `name`='{$case2}'");
	    $imgcase =  $cases['img'];
        $en = addslashes($cs['name']);
        $pricew = $cs['price'];
		
		$date = date('Y-m-d H:i:s');
		$pdo->query("INSERT INTO `last` (`username`, `userid`, `casename`, `weapon`, `type`, `img`, `imgcase`) VALUES (\"{$_SESSION['name']}\", \"{$_SESSION['id']}\", \"{$case2}\", \"{$engfullname}\", \"{$type}\", \"{$image}\", \"{$imgcase}\")");
  
		$pdo->query("INSERT INTO `inventory` (`weapon`, `second`, `seconden`, `type`, `img`, `price`, `case`, `user`, `status`, `datatime`) VALUES (\"{$firstName}\", \"{$secondName}\", \"{$en}\", '{$type}', \"{$image}\", '{$pricew}', '{$case2}', '{$_SESSION['id']}', 'progress', '{$date}')");
        $inventory_item_id = $pdo->lastInsertId();
		$pdo->query("UPDATE `users` SET `profit` = `profit` + '$pricew2' WHERE `steam`='{$_SESSION['steamid']}'");
	} 
	else $pdo->query("UPDATE `games` SET `iteamsid`='{$itemsarrs}' WHERE `gamenum`='{$gamenum}' AND `userid`='{$_SESSION['id']}'");
	$data = array();
	        $data['status']= 'success';
			$data['iteamid']= $inventory_item_id;
			$data['case_id']=$scratchid;
			$data['weapon']['type']=        $type;  
			$data['weapon']['price']=        $pricew;  
            $data['weapon']['image']=        'https://steamcommunity-a.akamaihd.net/economy/image/'.$image .'/125x125f';        
			$data['weapon']['fullname']=      $firstName;
			$data['weapon']['spacename']=      $secondName;
	
    echo json_encode($data);
	}else  die('{"status":"error","msg":"notloggin"}');
}

/* 
	Отправка оружия
*/
if (trim($_POST["action"]) == "send") {
    $return = $_POST;
    $cookie_name = 'exabyte_url';
	
    if (!isset($_COOKIE['send_timeout'])) {
        $checkwp = $pdo->__fetch("SELECT * FROM `inventory` WHERE `id`='{$return['id']}'");
        if ($checkwp['user'] == $_SESSION['id']) {
            if ($checkwp['status'] == 'selled') exit();
            $pdo->query("UPDATE `inventory` SET `status` = 'notcompleted' WHERE `id`='{$return['id']}' and `user`='{$_SESSION['id']}'");
            $tradelink = $pdo->__fetch("SELECT * FROM `users` WHERE `steam` = '{$_SESSION['steamid']}'");
            $row3 = explode("https://steamcommunity.com/tradeoffer/new/?", $tradelink['link'], 2);
            $row2 = explode("partner=", $row3[1]);
            $row = explode("&token=", $row2[1]);

            $return['status'] = 'success';
            $return['wp'] = $return["weapon"];
            $return['steam'] = $_SESSION['steamid'];
            $return['details'] = $tradelink;
            $return['id'] = $return["id"];
            $price = $return['price'];
            $return['userid'] = $_SESSION['id'];
		    $lol = 'lol';
            $return['pre'] = md5($return['wp'].$lol);
            $pdo->query("UPDATE `inventory` SET `status` = 'send',`token` = '{$row[1]}',`partner` = '{$row[0]}' WHERE `id`='{$return['id']}' and `user`='{$_SESSION['id']}'");
            setcookie('send_timeout', $return["weapon"], time() + (60), '/');
        } else {
            $return['status'] = 'error';
        }
    } else {
        $return['status'] = 'cookie';
    }
    echo json_encode($return);
}
