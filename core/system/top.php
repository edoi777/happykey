<?php
class System_top extends connect
{
	function tops(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `users` ORDER BY profit DESC LIMIT 3");
		
		foreach ($data as $row){
			//$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$avatar = str_replace("medium", "full", $row['avatar']);;
			$type = $row['type'];
			$top_three++;
			if($top_three == 1) {
				$topnum = 'place1';
			}
			if($top_three == 2) {
				$topnum = 'place2';
			}
			if($top_three == 3) {
				$topnum = 'place3';
			}
			$el .= '
			<div class="topthree_list">
			<figure>
			<img src="'.$avatar.'">
			</figure>
			<span class="icon">'.$top_three.'</span>
			<span class="name"><a>'.$row['name'].'</a></span>
			<span class="descr">выиграл игр: <span class="quantity">'.$row['cases'].'</span></span>
		</div>';
		}
		return $el;
	}

	function topses(){
		$top_three = 3;
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		
		$data = $pdo->query("SELECT * FROM `users` ORDER BY profit DESC LIMIT 3, 17");
		
		foreach ($data as $row){
			//$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
			$avatar = str_replace("medium", "full", $row['avatar']);;
			$type = $row['type'];
			$top_three++;
			$el .= '
			
			
			<tr>
		   <td>'.$top_three.'</td>
		   <td style="margin-left: 223px;float: left;">
		   <figure>
		   <img src="'.$row['avatar'].'">
		   </figure>
		   <a>'.$row['name'].'</a>
		   </td>
		   <td>'.$row['cases'].'</td>
		   </tr>';
		}
		return $el;
	}

	function action_index()
	{
		return array($this->tops(),$this->topses());
	}
} 