<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<?
    $username=$_SESSION["login"];
    $tableName=hash("md5",$username);
    $dbLink=new mysqli("localhost","root","","filesharer");
    $res=$dbLink->query("SELECT COUNT(*) FROM $tableName");
    $resObj=$res->fetch_array();
    if($resObj[0]==0){
        echo "<h1 class='title is-1'>Вы еще не загружали файлов</h1>";
        exit;
    }
    $countInPage=6;
    $rowCount=(int)ceil($resObj[0]/$countInPage);
    if(isset($_GET["num"])){
        $currentPageNum=$_GET["num"];
    }else{
        $currentPageNum=1;
    }
    if($currentPageNum>$rowCount){
        $currentPageNum=$rowCount;
    }
    if($currentPageNum<1){
        $currentPageNum=1;
    }
    $res->close();
?>

<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Имя файла</th>
            <th>Дата загрузки</th>
            <th>код файла</th>
            <th>ссылка на скачивание</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $startPos=($currentPageNum-1)*$countInPage;
        $res=$dbLink->query("SELECT * FROM $tableName LIMIT $startPos,$countInPage");
        while($row=$res->fetch_assoc()){
            $rowId=$row["id"];
            $password=$row["password"];
            $fileName=$row["filename"];
            $loaddate=$row["loaddate"];
            $fileCode="$tableName-".$row["filenamehash"];
            $code="$fileCode";
            $fileCodeFull="`$fileCode`";
            $downloadLink="localhost/FileSharer/getFile.php?code=$code";
            $fullDownloadLink="`$downloadLink`";
            if(strlen($fileCode)>10){
                $fileCode=substr($fileCode,0,9)."...";
            }
            if(strlen($downloadLink)>10){
                $downloadLink=substr($downloadLink,0,9)."...";
            }
            echo "<tr id='row$rowId'>";
            echo "<td>$fileName</td>";
            echo "<td>$loaddate</td>";
            echo "<td>$fileCode <button class='button is-link' onclick='copyToClickboard($fileCodeFull)'>копировать</button></td>";
            echo "<td>$downloadLink <button class='button is-link' onclick='copyToClickboard($fullDownloadLink)'>копировать</button></td>";
            echo "<td><a class='button is-primary' onclick='downloadButClick($fileCodeFull,`$password`)'><i class='fas fa-arrow-alt-circle-down'></i></a></td>";
            echo "<td><a class='delete is-large' onclick='deleteButClick($rowId)'></a></td>";
        }
        ?>
    </tbody>
</table>

<nav class="pagination" role="navigation" aria-label="pagination">
    <?
        //кнопка перехода на предыдущую страницу
        $disFirst=($currentPageNum==1)?"disabled":"";
        $nextPageNum=$currentPageNum-1;
        echo "<a class='pagination-previous' href='uploaded.php?num=$nextPageNum' $disFirst>Предыдущая</a>";
    ?>
    <?
        //кнопка перехода на следующую
        $disLast=($currentPageNum==$rowCount)?"disabled":"";
        $prevPageNum=$currentPageNum+1;
        echo "<a class='pagination-next' href='uploaded.php?num=$prevPageNum' $disLast>Следующая</a>";
    ?>
    <ul class="pagination-list">
    <?
        for($i=1;$i<=$rowCount;$i++){
            $cur="";
            if($currentPageNum==$i){
                $cur="is-current";
            }
            echo "<li><a class='pagination-link $cur' href='uploaded.php?num=$i'>$i</a></li>";
        }
    ?>
    </ul>
</nav>

<script>
    function copyToClickboard(text){
        navigator.clipboard.writeText(text)
          .then(() => {
            alert("скопировано в буфер обмена");
          });
    }
    function deleteButClick(id){
        const xhr = new XMLHttpRequest();
        xhr.open('GET','php/deleteFile.php?id='+id, true);
        xhr.send();
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status == 200) {
                console.log(xhr.responseText);
                if(xhr.responseText=="OK"){
                    location.reload();
                }else{
                    alert("произошла ошибка, попробуйте позже")
                }
            }

        }
    }
    function downloadButClick(filecode,password){
        if(password!=""){
            location.href="getFile.php?code="+filecode+"&password="+password;
        }else{
            location.href="getFile.php?code="+filecode;
        }
    }
</script>