<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
ob_start();
require ('core/steamauth/openid.php');
include 'config.php';
$myConnect = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']); 
mysql_select_db($config['db']['base'],$myConnect);
function fetchinfo($rowname, $tablename, $finder, $findervalue){
	if ($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
	else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'") or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row[$rowname];
}

function steamlogin()
{
try {
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
    
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
}

     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) { 
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
              
                $_SESSION['steamid'] = $matches[1]; 
                $_SESSION['auth'] = true; 
                $_SESSION['lang'] = 'ru';                
			$opts = array(
				'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
							"Cookie: foo=bar\r\n"
				)
			);
			$context = stream_context_create($opts);
            include 'config.php';
            $urljson = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$config['apikey']."&steamids=".$_SESSION['steamid'], false, $context);
            $data = json_decode($urljson, true);
			$myConnect = mysql_connect($config['db']['host'],$config['db']['user'],$config['db']['pass']); 
            mysql_select_db($config['db']['base'],$myConnect);
            $_SESSION['name'] = $data['response']['players'][0]['personaname'];
            $_SESSION['avatar'] = $data['response']['players'][0]['avatarfull'];
                $query = mysql_query("SELECT * FROM users WHERE steam='".$_SESSION['steamid']."'");
                if (mysql_num_rows($query) == 0) {
					$ref = 0;
					$mnr = 0;
					$mnt= 0;
					if (isset($_COOKIE['signup_ref'])) {
						$ref = fetchinfo("steam", "users", "id", $_COOKIE['signup_ref']);
				        $mnr = fetchinfo("value", "info", "name",  "refmoney");
						$mnt = fetchinfo("value", "info", "name",  "refto");
						mysql_query("UPDATE users SET `money`=`money`+'$mnr' WHERE id='".$_COOKIE['signup_ref']."'");
					}
                    mysql_query("SET NAMES 'utf8'");
					mysql_query("SET CHARACTER SET 'utf8'");
					$money = 0+$mnt;
                    mysql_query("INSERT INTO users (steam, name, avatar,ref,money,refmoney) VALUES ('".$_SESSION['steamid']."',  \"".$_SESSION['name']."\", '".$_SESSION['avatar']."','".$ref."','".$money."','".$mnr."')") or die("MySQL ERROR: ".mysql_error());
                }else{
					mysql_query("UPDATE users SET avatar='".$_SESSION['avatar']."', name='".$_SESSION['name']."' WHERE steam='".$_SESSION['steamid']."'");
				}  
                header("Location: http://".$_SERVER['HTTP_HOST']);
               
        } else {
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}
function vklogin()
{
	include 'config.php';
try {
    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $config['client_id'],
        'redirect_uri'  => 'http://'.$config['site'],
        'response_type' => 'code'
    );
    header ('Location: '.$url . '?' . urldecode(http_build_query($params)));  
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}
function vklogincode($code)
{
	include 'config.php';
try {
    $result = false;
    $params = array(
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'],
        'code' => $_GET['code'],
        'redirect_uri' => 'http://'.$config['site']
    );

    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

    if (isset($token['access_token'])) {
        $params = array(
            'uids'         => $token['user_id'],
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token']
        );

        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['uid'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }

    if ($result) {
		$_SESSION['steamid'] =  $userInfo['uid']; 
        $_SESSION['auth'] = true; 
        $_SESSION['lang'] = 'ru';
        $_SESSION['name'] = $userInfo['first_name'];
        $_SESSION['avatar'] = $userInfo['photo_big'];

                //include_once("set.php");
                $query = mysql_query("SELECT * FROM users WHERE steam='".$_SESSION['steamid']."'");
                if (mysql_num_rows($query) == 0) {
					$ref = 0;
					$mnr = 0;
					$mnt= 0;
					if (isset($_COOKIE['signup_ref'])) {
						$ref = fetchinfo("steam", "users", "id", $_COOKIE['signup_ref']);
				        $mnr = fetchinfo("value", "info", "name",  "refmoney");
						$mnt = fetchinfo("value", "info", "name",  "refto");
					}
                    mysql_query("SET NAMES 'utf8'");
					mysql_query("SET CHARACTER SET 'utf8'");
					$money = 0+$mnt;
					mysql_query("UPDATE users SET `money`=`money`+'$mnr' WHERE id='".$_COOKIE['signup_ref']."'");
                    mysql_query("INSERT INTO users (steam, name, avatar,ref,money,refmoney) VALUES ('".$_SESSION['steamid']."',  \"".$_SESSION['name']."\", '".$_SESSION['avatar']."','".$ref."','".$money."','".$mnr."')") or die("MySQL ERROR: ".mysql_error());
                }else{
					mysql_query("UPDATE users SET avatar='".$_SESSION['avatar']."', name='".$_SESSION['name']."' WHERE steam='".$_SESSION['steamid']."'");
				}      
    }
	header("Location: http://".$_SERVER['HTTP_HOST']);
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}
?>
