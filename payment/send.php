<?php
include "../config.php";
if(isset($_GET['sum'])){
$merchant_id = $config['freekasa']['id']; /// login freekassa
$secret_word = $config['freekasa']['secret1'];; /// secret 2
if(empty($_GET['sum'])) {
	$order_amount = 29;
}else {
	$order_amount = $_GET['sum'];
}

$u = $_SESSION['id'];

$order_id = $u.'_'.$order_amount.'_'.time();
setcookie("order_id", $order_id, time()+3600);
$sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
header('Location: http://www.free-kassa.ru/merchant/cash.php?m='.$merchant_id.'&oa='.$order_amount.'&o='.$order_id.'&s='.$sign.'&lang=ru&us_login='.$u.'');
exit();

}else{
	echo 'error';
}
?>