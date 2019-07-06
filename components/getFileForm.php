
<?
$code=$_GET["code"];
$codeArr=explode("-",$code);
$tableName=$codeArr[0];
$fileName=$codeArr[1];
$dbLink=new mysqli("localhost","root","","filesharer");
$res=$dbLink->query("SELECT * FROM $tableName WHERE filenamehash='$fileName'");
if(!$res){
    echo "<h1 class='title is-1'>Нет такого файла:(</h1>";
    exit;
}
$row=$res->fetch_assoc();
if($row["password"]!==null){
    if(!isset($_GET["password"])){
        echo "<script>location.href='filePasswordForm.php?code=$code';</script>";
    }elseif($_GET["password"]!=$row["password"]){
        echo "<script>location.href='filePasswordForm.php>code=$code';</script>";
    }
}
?>

<div class="content">
    <p>имя файла: <span class="has-text-info" id="fileNameSpan"><?echo $row["filename"];?></span></p>
    <p>дата загрузки: <span class="has-text-info" id="loadDateSpan"><?echo $row["loaddate"];?></span></p>
    <div class="button is-link" id="downloadBut">скачать</div>
</div>

<script>
    let code=get('code');
    document.getElementById("downloadBut").addEventListener("click",()=>{
        let filename=document.getElementById("fileNameSpan").innerHTML;
        window.open("downloadFile.php?code="+code+"&name="+filename);
    })

    function get(name){
        if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
    }
</script>
