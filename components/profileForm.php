<div class="card">
    <div class="card-content">    
        <nav class="panel">
            <p class="panel-heading">
                личный кабинет
            </p>
            <div class="panel-block">
                <div class="container"><span>Логин: <span class="has-text-primary"><?echo $_SESSION["login"];?></span></span></div>
            </div>
        </nav>
    </div>
    <div class="card-footer">
        <div class="card-footer-item button is-danger" id="exitButton">выйти</div>
    </div>
</div>

<script>
    const exitBut=document.querySelector("#exitButton");
    exitBut.addEventListener("click",()=>{
        const xhr = new XMLHttpRequest();
        xhr.open('GET','php/doLogout.php', true);
        xhr.send();
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status == 200) {
                console.log(xhr.responseText);
                if(xhr.responseText=="OK"){
                    location.href="index.php";
                }else{
                    alert("произошла ошибка, попробуйте позже");
                }
            }

        }
    })

</script>