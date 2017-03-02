<?php
	session_start();
	include "config.php";
	require_once("payment.class.php");
	$pay = new payment();
	if (isset($_REQUEST['sum'])) {
		header ("Location: ".$pay->pay_form($_REQUEST['sum'], $pay->config['user_param'], 'interkassa'));
	} else if (isset($_REQUEST['method']) && isset($_REQUEST['params'])) {
		switch (strtolower($_REQUEST['method'])) {
			case "check" :
				echo $pay->up_sign($_REQUEST['params']); 
			break;
			case "pay" :
				echo $pay->up_sign($_REQUEST['params']);
				$pay->pay($_REQUEST['params']['sum'], $_REQUEST['params']['account']);
			break;
			default :
				$pay->up_json_reply("error", $_REQUEST['params']);
			break;
		}
		exit();
	} else {
		if (isset($_GET['reply'])) {
			echo $config['message'][$_GET['reply']];
		} else {
			if(!$pay->ik_sign($_REQUEST)) exit("403");
			$pay->pay($_REQUEST['ik_am'], $_REQUEST['ik_pm_no']);
		}
	}
?>