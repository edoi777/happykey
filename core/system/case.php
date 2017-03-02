<?php
class System_case extends connect
{
	function getnormal($id){
		global $pdo;
        $dataf = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='".$id."'");
        return $dataf['disp_name'];
	}
	
	function getbuttom($id){
		global $pdo;
        $data = $pdo->query("SELECT * FROM `cases` WHERE `name`='".$id."'");
		$btn = '';
		$casein = true;
        foreach ($data as $row){
			if(isset($_SESSION['steamid'])){
				$dataf = $pdo->__fetch("SELECT * FROM `users` WHERE `id`='{$_SESSION['id']}'");
                if($dataf['money'] > $row['price']){
					$btn = '<div class="shutupandtakemymoney"><img class="shut-light loader" src="/template/img/buycard_light.png"><button class="gold tutor_auth" id="startgame">Разыграть билет за '.$row['price'].' руб.</button><div class="putmoney-block"><div class="putmoney-inner mini">
                            <p style="padding: 0; margin: 0;">Желаем вам удачи!</p>
                            </div></div></div>';	
				}else{
					$pay = $row['price']-$dataf['money'];
					$btn = '<div class="shutupandtakemymoney"><img class="shut-light loader" src="/template/img/buycard_light.png"><button class="gold tutor_auth">Разыграть билет за '.$row['price'].' руб.</button><div class="putmoney-block"><div class="putmoney-inner mini">
                            <p style="padding: 0; margin: 0;">Пожалуйста, <a href="/user/me" class="link login">пополните счёт на '.$pay.'</a> руб.</p>
                            </div></div></div>';
				}

			}else{
	          	$btn = '<div class="shutupandtakemymoney"><img class="shut-light loader" src="/template/img/buycard_light.png"><button class="gold tutor_auth">Открыть...</button><div class="putmoney-block"><div class="putmoney-inner mini">
               <p style="padding: 0; margin: 0;">Пожалуйста, <a href="/?login" class="link login">авторизуйтесь!</a></p>
                </div></div></div>';				
			}

        }
		return $btn;
	}
	function getimage($id){
		global $pdo;
        $data = $pdo->__fetch("SELECT * FROM `cases` WHERE `name`='".$id."'");

		return $data['img'];
	}
	function action_index($id){
		return array($id, $this->getnormal($id), $this->getbuttom($id), $this->getimage($id));		
	}
} 