<?
$pass=$_GET["password"];
$code=$_GET["code"];
$codeArr=explode("-",$code);
$tableName=$codeArr[0];
$fileHashName=$codeArr[1];
$dbLink=new mysqli("localhost","root","","filesharer");
$res=$dbLink->query("SELECT password FROM $tableName WHERE filenamehash='$fileHashName'");
$row=$res->fetch_assoc();
if($pass==$row["password"])echo "OK";else echo " aerr";