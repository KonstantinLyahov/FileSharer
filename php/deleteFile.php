<?
session_start();
$username=$_SESSION["login"];
$usernameHash=hash("md5",$username);
$id=$_GET["id"];
$dbLink=new mysqli("localhost","root","","filesharer");
$res=$dbLink->query("SELECT filenamehash FROM `$usernameHash` WHERE id=$id");
$row=$res->fetch_assoc();
$filename=$row["filenamehash"];
$filepath="../ServerFolder/$usernameHash/$filename";
unlink($filepath);
$res=$dbLink->query("DELETE FROM `$usernameHash` WHERE id=$id");
if($res==null){
    echo "err";
}
echo "OK";