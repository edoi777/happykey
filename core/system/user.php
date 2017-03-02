<?php
class System_user extends connect
{
	function getavatar($id){
		global $pdo;	
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$id}'");		
		return $data['avatar'];
	}
	function getname($id){
		global $pdo;	
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$id}'");		
		return $data['name'];
	}	
	function getop($id){
		global $pdo;	
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$id}'");		
		return $data['cases'];
	}	
	function getlink($id){
		global $pdo;
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$id}'");
		$link = $data['steam'];
		$profile = '';
		if (strpos($link, '7656') !== false){
			$profile = '<a class="buttonlink gold" href="http://steamcommunity.com/profiles/'.$link.'" target="_blank">Аккаунт в Steam</a>';
		}else {
			$profile = '<a class="buttonlink gold" href="http://vk.com/id'.$link.'" target="_blank">VK</a>	';
		}	 
		return $profile;
	}
	function getlevel($id){
		global $pdo;
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '{$id}'");
		$mylvl = $data['cases'];
		
		if($mylvl<=4){
			$fornextlvl = 5;
			$prev ='<img src="/template/img/lvl/1.png"><span>Сильвер I</span>';
			$next ='<img src="/template/img/lvl/2.png"><div class="next-rang__user">Сильвер II</div>';
		}else if($mylvl<=9){
			$fornextlvl = 10;
			$prev ='<img src="/template/img/lvl/2.png"><span>Сильвер II</span>';
			$next ='<img src="/template/img/lvl/3.png"><div class="next-rang__user">Сильвер III</div>';
		}else if($mylvl<=14){
			$fornextlvl = 15;
			$prev ='<img src="/template/img/lvl/3.png"><span>Сильвер III</span>';
			$next ='<img src="/template/img/lvl/4.png"><div class="next-rang__user">Сильвер IV</div>';
		}else if($mylvl<=19){
			$fornextlvl = 20;
			$prev ='<img src="/template/img/lvl/4.png"><span>Сильвер IV</span>';
			$next ='<img src="/template/img/lvl/5.png"><div class="next-rang__user">Сильвер V</div>';
		}else if($mylvl<=24){
			$fornextlvl = 25;
			$prev ='<img src="/template/img/lvl/5.png"><span>Сильвер V</span>';
			$next ='<img src="/template/img/lvl/6.png"><div class="next-rang__user">Тащер I</div>';
		}else if($mylvl<=29){
			$fornextlvl = 30;
			$prev ='<img src="/template/img/lvl/6.png"><span>Тащер I</span>';
			$next ='<img src="/template/img/lvl/7.png"><div class="next-rang__user">Тащер II</div>';
		}else if($mylvl<=34){
			$fornextlvl = 35;
			$prev ='<img src="/template/img/lvl/7.png"><span>Тащер II</span>';
			$next ='<img src="/template/img/lvl/8.png"><div class="next-rang__user">Тащер III</div>';
		}else if($mylvl<=39){
			$fornextlvl = 40;
			$prev ='<img src="/template/img/lvl/8.png"><span>Тащер III</span>';
			$next ='<img src="/template/img/lvl/9.png"><div class="next-rang__user">Тащер IV</div>';
		}else if($mylvl<=44){
			$fornextlvl = 45;
			$prev ='<img src="/template/img/lvl/9.png"><span>Тащер IV</span>';
			$next ='<img src="/template/img/lvl/10.png"><div class="next-rang__user">Тащер V</div>';
		}else if($mylvl<=49){
			$fornextlvl = 50;
			$prev ='<img src="/template/img/lvl/10.png"><span>Тащер V</span>';
			$next ='<img src="/template/img/lvl/11.png"><div class="next-rang__user">Глобал I</div>';
		}else if($mylvl<=54){
			$fornextlvl = 55;
			$prev ='<img src="/template/img/lvl/11.png"><span>Глобал I</span>';
			$next ='<img src="/template/img/lvl/12.png"><div class="next-rang__user">Глобал II</div>';
		}else if($mylvl<=59){
			$fornextlvl = 60;
			$prev ='<img src="/template/img/lvl/12.png"><span>Глобал III</span>';
			$next ='<img src="/template/img/lvl/13.png"><div class="next-rang__user">Глобал IV</div>';
		}else if($mylvl<=64){
			$fornextlvl = 65;
			$prev ='<img src="/template/img/lvl/13.png"><span>IV</span>';
			$next ='<img src="/template/img/lvl/14.png"><div class="next-rang__user">Глобал V</div>';
		}else {
			$fornextlvl = 0;
			$prev ='<img src="/template/img/lvl/14.png"><span>Глобал IV</span>';
			$next ='<img src="/template/img/lvl/15.png"><div class="next-rang__user">Питух</div>';
		}		
		$pps = $fornextlvl-$mylvl;
		if($pps==5){
			$god='';
		}else if($pps== 4){
			$god=20;
		}else if($pps== 3){
			$god=40;
		}else if($pps== 2){
			$god=60;
		}else if($pps== 1){
			$god=80;
		}else $god=100;
		
		$lavel = '	<div class="skills-progress"><div class="prev-rang">'.$prev.'</div><div class="skill-progress"><div class="progressbar" data-perc="0" data-verc="'.$god.'">
		            <div class="bar"><span style="width: 0%;"></span><b style="width: 0%;"></b></div><div class="label"><span></span><div class="perc">'.$god.'0/ 1000 </div></div></div></div>
                    <div class="next-rang"><div class="next-rang__p">Следующий ранг</div>'.$next.'</div></div>';
		return $lavel;
	}
	function getitems($id){
		global $pdo;
		$el= '';
		//Инвентарь
		$inv = $pdo->query("SELECT * FROM `inventory` WHERE `user`='{$id}' ORDER BY `id` DESC LIMIT 20");
		if($inv){	
			foreach ($inv as $row){
				$cs = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='{$row['case']}'");
				
				$full_name = $row['weapon'].' | '.$row['second'];
				$type = $row['type'];
				if($row['status'] == 'completed') {
							$status = '<span class="status-icon" title="Предмет получен"></span>';
				}
				if($row['status'] == 'progress'){
					 $status = '<span class="status-icon" title="Предмет отправлен"></span>';
				}
				if($row['status'] == 'selled') {
					$status = '<span class="status-icon" title="Предмет продан"></span>';
				}
				else {
					$status = '<span class="status-icon" title="Предмет отправлен"></span>';
				}
				$el .= '<div class="item-incase '.$type.'">
				<div class="ii-status progress">
				'.$status.'		
					<span class="steam-money" title="Цена предмета в Steam">'.$row['price'].'<small>p</small></span>
			     </div>
				<div class="picture">
		<img src="https://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'].'/160fx120f/image.png" alt="Дроп" class="drop-image">
		
		
			<img src="'.$cs['img'].'" alt="" class="case-image" style="opacity: 0;">
		

		<div class="descr">
			<strong>'.$row['weapon'].'</strong>
			<span>'.$row['second'].'</span>
		</div>
	</div>
				
				
				
				
				
				
				</div>';
        	}

		}	
	    return $el;
	}
	function action_index($id){
		return array($this->getavatar($id), $this->getlink($id), $this->getitems($id), $this->getlevel($id),$this->getname($id),$this->getop($id));		
	}
} 