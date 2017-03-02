<?php
class System_list extends connect
{

	function getlist(){
		global $config;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);
		$refg = $pdo->query("SELECT * FROM `users` WHERE `ref`='{$_SESSION['steamid']}'");
		$refgg = $pdo->__fetch("SELECT SUM(refmoney) AS refmoney FROM `users` WHERE `ref`='{$_SESSION['steamid']}'");		
		
		$refs.='
									<div class="ref-stat">
									<div class="w25">
										<span>'.$refg->rowCount().'</span>
										<i>Зарегистрировались</i>
									</div>
									<div class="w25">
										<span>'.$refgg['refmoney'].' <small>p</small></span>
										<i>Ваш заработок</i>
									</div>
								</div>
		
		
		
		
		<table class="top_table" ng-show="top.loaded">
        <thead>
        <tr>
            <td>Имя</td>
            <td>Прибыли</td>
            <td>Кейсов открыл</td>
        </tr>
        </thead>
         <tbody>';
       	$data = $pdo->query("SELECT * FROM `users` WHERE `ref`='{$_SESSION['steamid']}' ORDER BY `id` DESC");
		
		foreach ($data as $row){
		$refs.='<tr class="ng-scope">          
            <td>
                <div class="table_avatar">
                    <img src="'.$row['avatar'].'">
                </div>
                <a target="_self" class="ng-binding" href="/user/'.$row['id'].'">'.$row['name'].'</a>
            </td>
            <td class="ng-binding">'.$row['refmoney'].' руб.</td>
           <td class="ng-binding">'.$row['cases'].'</td>
        </tr>';
		}
			
			
    $refs.='</tbody></table>';
	return $refs;
	}

	
	function action_index()
	{
		return array($this->getlist());
	}
} 