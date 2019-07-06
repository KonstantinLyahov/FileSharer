<?
session_start();
require("cl/File.php");
if(isset($_POST["password"])){
    $password=$_POST["password"];
}else{
    $password=null;
}

if(!$_SESSION["login"])exit;
$upfile=new File($_SESSION["login"]); 
$upfile->upload($_FILES["file"],$password);

$fileLink=$upfile->getLink();
$fileName=$upfile->getName();

$fileInf=(object)array("link"=>$fileLink,"name"=>$fileName);

echo json_encode($fileInf);
?>
