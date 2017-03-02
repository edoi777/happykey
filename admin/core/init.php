<?php
session_start();
require_once('config.php');
require_once('pdo.mysql.php');
$db = new db(DB_USER, DB_PASS, DB_HOST, DB_NAME, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$URI = $_SERVER['REQUEST_URI'];
$URIa = explode('/',$URI);

/* LOGIN CHECK */
if(isset($_SESSION["steamid"])) {
	$qd = $db->getRow('SELECT * FROM `users` WHERE `steam` = \''.$_SESSION['steamid'].'\'');
	if($qd['admin'] == 1) $_LOGGED_IN = true;
	else $_LOGGED_IN = false;
	$_USERNAME = ADMIN_LOGIN;
	/* GRAB STATS IF LOGGED IN */
	$q = $db->getRow('SELECT COUNT(*) as cnt FROM histories WHERE status = 1');
	$games_count = $q['cnt'];
	$q = $db->getRow('SELECT COUNT(*) as cnt FROM support');
	$support_count = $q['cnt'];
	if($URIa[2]=='ajax') {
		header('Content-type: text/css; charset=UTF-8');
		$AJAX_MODULES_PATH = $_SERVER['DOCUMENT_ROOT'].'/admin/core/ajax_modules/';
		$AJAX_MODULE = str_replace('..','',$URIa[3]);
		if(file_exists($AJAX_MODULES_PATH.$AJAX_MODULE.'.php')) 
			include($AJAX_MODULES_PATH.$AJAX_MODULE.'.php');
		else
			include($AJAX_MODULES_PATH.'default.php');
		exit;
	}
}
else {
	$_LOGGED_IN = false;
	if($_POST) {
		if($_POST['u']==ADMIN_LOGIN && $_POST['p']==ADMIN_PASSW) {
			$_LOGGED_IN = true;
			$_SESSION['admin_login'] = 1;
			$_SESSION['admin_token'] = 
			md5('fuckinawesomeshit, I fuck your mam if you look this code ,remembar you FAGGOT! : '.time().rand(10000,99999));
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/#success');exit;
		}
		else {
			sleep(5);
		}
	}
}
?>
