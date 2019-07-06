<?php
session_start();
unset($_SESSION["login"]);
$_SESSION["logged"]=false;
setcookie("login",null,-1,"/");
echo "OK";

?>