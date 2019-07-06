введите код файла: <input id="code" class="input is-primary is-small" type="text" style="width:300px"><br><br>
<div class="button is-info" id="findBut">Найти</div>
<script>
    document.getElementById("findBut").addEventListener("click",()=>{
        location.href="getFile.php?code="+document.getElementById("code").value;
    })
</script>