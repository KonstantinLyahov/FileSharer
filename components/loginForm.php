<div class="field">
  <label class="label">Логин</label>
  <div class="control">
    <input class="input is-medium" type="text" placeholder="" id="loginInput">
  </div>
  <p class="help" id="loginHelp"></p>
</div>

<div class="field">
  <label class="label">Пароль</label>
  <div class="control">
    <input class="input is-medium" type="password" placeholder="" id="passwordInput">
  </div>
  <p class="help" id="passwordHelp"></p>
</div>

<div class="field">
  <div class="control has-text-centered">
    <label class="checkbox">        
        <input type="checkbox" id="rememberCheckbox">        
        Запомнить меня
    </label>
  </div>
</div>

<button class="button" id="readyBut">Готово</button>
<p class="help is-danger" id="err"></p>

<script>
    const readyBut=document.querySelector("#readyBut");

    readyBut.addEventListener("click",()=>{
        let login=document.querySelector("#loginInput").value;
        let password=document.querySelector("#passwordInput").value;
        let remember=""+document.querySelector("#rememberCheckbox").checked;
        const xhr = new XMLHttpRequest();
        xhr.open('GET','php/doLogin.php?login='+login+'&password='+password+"&remember="+remember, true);
        xhr.send();
        readyBut.className="button is-loading";
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status == 200) {
                console.log(xhr.responseText);
                if(xhr.responseText=="OK"){
                    readyBut.className="button";
                    location.href="index.php";
                }else{
                    readyBut.className="button";
                    document.querySelector("#err").innerHTML="неверный логин или пароль";
                }
            }

        }
    })
</script>