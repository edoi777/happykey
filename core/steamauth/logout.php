<?php
header("Location: http://".$_SERVER['HTTP_HOST']);
session_start();
unset($_SESSION['name']);
unset($_SESSION['avatar']);
unset($_SESSION['steamid']);
unset($_SESSION['auth']);
unset($_SESSION['steam_uptodate']);
?>