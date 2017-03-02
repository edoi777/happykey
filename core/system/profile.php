<?php
class System_profile extends connect
{
	function links(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		
		return $data['link'];
	}
	
	function money(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		
		return $data['money'];
	}
	function getgame(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
       	$data = $pdo->query("SELECT * FROM `last` WHERE `userid`='{$_SESSION['steamid']}' ORDER BY `id` DESC");
		
		foreach ($data as $row){
		$last.='
		<tr>
          <td style="padding: 15px;    text-align: center;">'.$row['game'].'</td>
          <td style="padding: 15px;    text-align: center;">'.$row['last'].'</td>
          <td style="padding: 15px;    text-align: center;"> '.$row['key'].'</td>
          </tr>';
		}
		

    return $last;
		
	}
	function img_full(){
		$ava = $_SESSION['avatar'];
		$av = str_replace("medium", "full", $ava);
		
		return $av;
	}
	function ref_id(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->__fetch("SELECT id FROM `users` WHERE `id` = '{$_SESSION['id']}'");
		
		return $data['id'];
	}
	function getref(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		$refg = $pdo->query("SELECT * FROM `users` WHERE `ref`='{$_SESSION['steamid']}'");
		$refgg = $pdo->__fetch("SELECT SUM(refmoney) AS refmoney FROM `users` WHERE `ref`='{$_SESSION['steamid']}'");		
       	$data = $pdo->query("SELECT * FROM `users` WHERE `ref`='{$_SESSION['steamid']}' ORDER BY `id` DESC");
		
		foreach ($data as $row){
		$refs.='	<tr>
          <td style="padding: 15px;    text-align: center;"><img src="'.$row['avatar'].'" style=" width: 40px;"></td>
          <td style="padding: 15px;    text-align: center;">'.$row['name'].'</td>
		   <td style="padding: 15px;    text-align: center;"> '.$row['cases'].'</td>
		    <td style="padding: 15px;    text-align: center;">'.$row['refmoney'].' руб.</td>
          </tr>';
		}
			
			
    $refs.='</tbody></table>';
	return $refs;
	}
	function inventory(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `inventory` WHERE `user`='{$_SESSION['id']}' ORDER BY `id` DESC");
		foreach ($data as $row){
			$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$full_name = $row['weapon'].' | '.$row['second'];
			$type = $row['type'];
			if($row['status'] == 'completed') {
				$status = '<div class="ii-status completed"><span class="status-icon" title="Получено"></span></div>';
				$sell = '';
				$send = '';
			}
			if($row['status'] == 'progress'){
				 $status = '';
				 $sell = '<div class="ii-status selled tosell" title="Продать за '.$row['price'].'P"><span class="status-icon" title="Продать за '.$row['price'].'P"></span></div>';
				 $send = '<div class="ii-status '.$row['status'].' sends"  ids="'.$row['id'].'" priced="'.$row['price'].'" namesw="'.$row['weapon'].' | '.$row['seconden'].'" title="Забрать предмет" ><span class="status-icon" title="Забрать предмет"></span></div>  ';
			}
			if($row['status'] == 'selled') {
				$status = '<div class="ii-status '.$row['status'].'"  title="Продано"><span class="status-icon" title="Продано"></span></div>';
				$sell = '';
				$send = '';
			}
			if($row['status']=='notfound'){
				$status = '';
				$sell = '<div class="tosell view"  ids="'.$row['id'].'" imgw="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'" case="'.$row['case'].'" title="Продать за '.$row['price'].'P"></div>';
				$send = '<div class="sends out" ids="'.$row['id'].'" priced="'.$row['price'].'" namesw="'.$row['weapon'].' | '.$row['seconden'].'" title="Предмет закончился"></div>';
			}
			if($row['status']=='send'){
				$status = '<div class="ii-status completed"  ><span class="status-icon" title="Отправлен"></span></div>';
				$sell = '';
				$send = '';
			}
			if($row['status']=='notcompleted'){
				$status = '';
				$sell = '<div class="tosell view"  ids="'.$row['id'].'" imgw="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'" case="'.$row['case'].'" title="Продать за '.$row['price'].'P"></div>';
				$send = '<div class="sends out" ids="'.$row['id'].'" priced="'.$row['price'].'" namesw="'.$row['weapon'].' | '.$row['seconden'].'" title="Забрать предмет"></div>';
			}
			$el .= '
			
			
			<div class="item-incase '.$type.'">
	
'. $send.'	
		'. $sell.'	
		'.$status.'
		<div class="ii-status progress">
				<span class="steam-money" style="top: 4px;" title="Цена предмета для продажи">'.$row['price'].'<small>p</small></span>
			     </div>
		
			
		
	
	<div class="picture">
		<img src="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'/160fx120f/" alt="Дроп" class="drop-image">			
			<img src="'.$cs['img'].'" alt="" class="case-image">
		<div class="descr">
			<strong>'.$row['weapon'].'</strong>
			<span>'.$row['second'].'</span>
		</div>
	</div></div>';
		}
		return $el;
	}
	
	function action_index()
	{
		return array($this->links(), $this->money(), $this->img_full(), $this->inventory(), $_SESSION['id'],$this->getref(),$this->getgame());
	}
} 