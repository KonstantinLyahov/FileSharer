<?
session_start();
$login=$_GET["login"];
$password=$_GET["password"];

$dbLink=new mysqli("localhost","root","","filesharer");
$str_query="select * from users where login='$login' and password='$password'";
$result=$dbLink->query($str_query);
if($result->num_rows!=0){
    $_SESSION["login"]=$login;
    $_SESSION["logged"]=true;
    if((bool)$_GET["remember"]){
        setcookie("login",$login,time() + 3600*24*30,"/");
        setcookie("password",$password,time() + 3600*24*30,"/");
    }
    echo "OK";
}else{
    echo "err";
}