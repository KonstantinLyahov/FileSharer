<?
session_start();
$_SESSION["logged"]=true;
$login=$_GET["login"];
$password=$_GET["password"];
$_SESSION["login"]=$login;
$dbLink=new mysqli("localhost","root","","filesharer");
$str_query="insert into users(login,password) values('$login','$password')";
$result=$dbLink->query($str_query);
if((bool)$_GET["remember"]){
    setcookie("login",$login,time() + 3600*24*30,"/");
    setcookie("password",$password,time() + 3600*24*30,"/");
}
$loginHash=hash("md5",$login);
$folderName="../ServerFolder/$loginHash";
mkdir($folderName);
$str_query="create table if not exists $loginHash(id int(10) auto_increment primary key,password varchar(30) default NULL,filename varchar(50) not null,filenamehash varchar(50) not null, loaddate TIMESTAMP DEFAULT CURRENT_TIMESTAMP) engine=myisam";
$dbLink->query($str_query);
echo "OK";