<?php
session_start();
define("BASE_URL", __DIR__);
include './config.php';
class Page
{	
	private function MenuFor($params)
	{
		unset($params['text']);
		unset($params['group']);
		foreach ($params as $key => $param)
		{
			if($param['group'] <= $_SESSION['info'][GROUP] || $param['group'] == 0) {
				$return .= set(
					"menu/element", 
					array(
						"{text}" => $param['text'],
						"{href}" => $key,
						"{class}" => (str_replace("/", NULL, $_SERVER['REQUEST_URI']) == str_replace("/", NULL, $key)) ? "active" : NULL
					)
				);
			}
		}
		return $return;
	}
	static function time_elapsed_string($datetime, $full = false) {
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
    static function generate($content, $action = "index", $case=null, $id = 0)
    {
		global $pdo;

		if(isset($case)){
			//$content = $case;
			/*$cases = set("case", array(
				"{case}" => $case
			));*/
			$case = str_replace(" ", "%20", $case);
			$content = file_get_contents ( 'http://'.$config['site'] . '/case/case.php?c='.$case );
			//$content = '<div class="preloader" style="display: block;"><div><img src="/template/img/preloader.GIF"></div></div><script>$("#content").load("/case/case.php?c='.$case.'");</script>';
		}
		include(BASE_URL . '/core/steamauth/steamauth.php');
	
  
		$head = set("menu/head", array("{title}" =>$_SERVER['HTTP_HOST']));
		$sesid = @$_SESSION['id'];
		$data = $pdo->__fetch("SELECT * FROM `users` WHERE `id` = '$sesid'");
		
		
		if(isset($_SESSION['auth'])){
		$profile = set("menu/profile", array(
		"{name}" => $_SESSION['name'], 
		"{avatar}" => $_SESSION['avatar'], 
		"{cases}" => $data['cases'],
		"{id}" => $_SESSION['id'], 
		"{link}" => $data['link'], 
		"{money}" => $data['money']
		));
		}else{
		$profile = set("menu/profile_nonlogin", array(
		"{name}" => ''
		));
		}
		/////BAN///////
		if($data['ban'] == 1) { 
			header('Location: http://natribu.org');
			exit();
		}
		//////BAN//////
		
		
		/////FREE//////
		if($data['free'] == 0) {
			$pdo->query("UPDATE `users` SET `free` = 1 WHERE `steam`='$sesid'");
			$pdo->query("UPDATE `users` SET `money` = `money` + 1 WHERE `steam`='$sesid'");
		}
		/////FREE//////
		$fd = '';
		$last = $pdo->query("SELECT * FROM `last` ORDER BY `id` DESC limit 16");
		while ($row = $last->fetch())
		{
			
			$fd .= '
			
			<div class="win">
			          <div class="win_image" style="background: url('.$row['imgcase'].') no-repeat center center;background-size:cover"></div>
			          <a style="text-decoration: none;" href="http://steamcommunity.com/profiles/'.$row['userid'].'" target="_blank"><div class="nick">'.$row['username'].'</div></a>
			          <div class="ago">'.Page::time_elapsed_string($row['last']).'</div>
		          </div>
		'; 
			
			
		}
	    $games = $pdo->query("SELECT * FROM `games`");
		$knife = $pdo->query("SELECT * FROM `last` WHERE `game` LIKE '%★%'");
		$usersd = $pdo->query("SELECT * FROM `users`");
		$covert = $pdo->query("SELECT * FROM `last`");
        if(isset($_SESSION['auth'])){
		//$fetch = $this->query("SELECT * FROM `pc_notific` ORDER BY `id` DESC LIMIT 0, 5")->fetchAll();
		//$note = set("menu/notific", array("{title_d}" => $fetch['title'], "{text}" => $fetch['desc']));
		echo set("menu/structure", array(
		"{last}" => $fd,
		"{name}" => $_SESSION['name'],
		"{covert}" => $covert->rowCount(),
		"{opens}" => $games->rowCount(),
        "{knife}" => $knife->rowCount(),		
		"{users}" => $usersd->rowCount(),	
		"{avatar}" => $_SESSION['avatar'], 
		"{money}" => $data['money'],
		"{profile}" => $profile, "{head}" => $head, "{content}" => $content));
		}else{
		echo set("menu/structure", array(
		"{last}" => $fd,
		"{name}" => null,
		"{covert}" => $covert->rowCount(),		
        "{knife}" => $knife->rowCount(),		
		"{opens}" => $games->rowCount(),	
		"{users}" => $usersd->rowCount(),	
		"{avatar}" => null, 
		"{money}" => $data['money'],
		"{profile}" => $profile, "{head}" => $head, "{content}" => $content));
		}
    }
}
?>