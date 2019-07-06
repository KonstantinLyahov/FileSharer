<?
$login=$_GET["login"];
$dbLink=new mysqli("localhost","root","","filesharer");
$str_query="select * from users where login='$login'";
$result=$dbLink->query($str_query);
if($result->num_rows===0){
    echo "1";
}
else{
    echo "0";
}