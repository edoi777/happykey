<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
define("BASE_URL", __DIR__);
require BASE_URL . '/config.php';
require BASE_URL . '/core/db/pdo.php';
require BASE_URL . '/core/db/db.php';
		global $pdo;
		$pdo = new DATABASE(
			"mysql:host={$config['db']['host']};dbname={$config['db']['base']}",
			$config['db']['user'],
			$config['db']['pass']
		);



require BASE_URL . '/core/system.php';
require BASE_URL . '/config.php';
require_once BASE_URL . '/core/structure.php';
require_once BASE_URL . '/core/route.php';


if(isset($_GET['logout'])){
	include('core/steamauth/logout.php');
	exit;
}

if(isset($_GET['login'])){
	include('core/steamauth/steamauth.php');
	steamlogin();
	exit;
}
if (isset($_GET['ref'])) SetCookie("signup_ref",$_GET['ref']);
if(isset($_GET['loginvk'])){
	include('core/steamauth/steamauth.php');
	vklogin();
	exit;
}
if (isset($_GET['code'])) {
	include('core/steamauth/steamauth.php');
	vklogincode($_GET['code']);
	exit;
}
if(isset($_GET['page'])&& $_GET['page']== 'profile'){
	if(!$_SESSION['auth']) Header ("Location: http://".$config['site']."");
}
if(isset($_GET['case'])){
	require_once BASE_URL . '/core/structure.php';
	require_once BASE_URL . '/core/route.php';	
	Page::Generate('0', '0', $_GET['case'],'0');
		
}

$page = (empty($_GET['page']) || $_GET['page'] == "/") ? "index" : $_GET['page'];

Page::Generate(Route::start($page, $_GET['id'], '0', '0'));

?>
