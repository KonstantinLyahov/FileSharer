<?php
$code=$_GET["code"];
$codeArr=explode("-",$code);
$tableName=$codeArr[0];
$fileHashName=$codeArr[1];
$name=$_GET["name"];
$fileHash="ServerFolder/$tableName/$fileHashName";
$file="ServerFolder/$tableName/$name";
copy($fileHash,$file);
$dbLink=new mysqli("localhost","root","","filesharer");
$res=$dbLink->query("SELECT * FROM $tableName WHERE password IS NOT NULL AND filenamehash='$fileName'");
$numRows=$res->num_rows;
if($numRows!=0){
    echo "<script>location.href='filePasswordForm.php?code=$code';</script>";
    exit;
}

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);
    exit;
}
?>