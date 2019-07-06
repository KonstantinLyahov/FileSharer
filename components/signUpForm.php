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
  <label class="label">Повторный пароль</label>
  <div class="control">
    <input class="input is-medium" type="password" placeholder="" id="repeatInput">
  </div>
  <p class="help" id="repeatHelp"></p>
</div>

<div class="field">
  <div class="control has-text-centered">
    <label class="checkbox">        
        <input type="checkbox" id="rememberCheckbox">        
        Запомнить меня
    </label>
  </div>
</div>

<button class="button" disabled id="readyBut">Готово</button>

<script>
    let allowedLogin=false;
    let allowedPassword=false;
    let allowedRepeat=false;
    const passwordRegExp=/^(?=.*\d).{4,8}$/;
    const loginInput=document.querySelector("#loginInput");
    const passwordInput=document.querySelector("#passwordInput");
    const repeatInput=document.querySelector("#repeatInput");
    const readyBut=document.querySelector("#readyBut");

    readyBut.addEventListener("click",()=>{
        const login=loginInput.value;
        const password=passwordInput.value;
        let remember=""+document.querySelector("#rememberCheckbox").checked;
        const xhr = new XMLHttpRequest();
        xhr.open('GET','php/doSignUp.php?login='+login+'&password='+password+"&remember="+remember, true);
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
                    alert("произошла ошибка, попробуйте позже");
                }
            }

        }
    })

    passwordInput.addEventListener("change",()=>{
        let value=passwordInput.value;
        const passHelp=document.querySelector("#passwordHelp");
        if(passwordRegExp.test(value)){
            passHelp.className="help is-success";
            passHelp.innerHTML="Хороший пароль"; 
            allowedPassword=true;
        }else{
            passHelp.className="help is-danger";
            passHelp.innerHTML="Плохой пароль";
            allowedPassword=false;
        }
        checkRepeat();
        checkIsAllowed()
    });

    loginInput.addEventListener("change",()=>{
        let value=loginInput.value;
        const loginRegExp=/^[a-z0-9_-]{3,16}$/;
        const loginHelp=document.querySelector("#loginHelp");
        if(!loginRegExp.test(value)){
            loginHelp.className="help is-danger";
            loginHelp.innerHTML="Логин недоступен";
            allowedLogin=false;
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('GET','php/checkName.php?login='+value, true);
        xhr.send();
        xhr.onreadystatechange = function() { // (3)
            if (xhr.readyState != 4) return;
            if (xhr.status == 200) {
                if(xhr.responseText=="0"){
                    loginHelp.className="help is-danger";
                    loginHelp.innerHTML="Логин недоступен";
                    allowedLogin=false;
                }else{
                    loginHelp.className="help is-success";
                    loginHelp.innerHTML="Логин доступен";
                    allowedLogin=true;
                }
            }

        }
        checkIsAllowed();
    });

    repeatInput.addEventListener("change",checkRepeat);

    function checkRepeat(){
        let value=repeatInput.value;
        const repeatHelp=document.querySelector("#repeatHelp");
        if(value===passwordInput.value){
            repeatHelp.innerHTML="";
            allowedRepeat=true;
        }else{
            repeatHelp.className="help is-danger";
            repeatHelp.innerHTML="Пароли должны совпадать";
            allowedRepeat=false;
        }
        checkIsAllowed();
    }
    
    function checkIsAllowed(){
        if(allowedRepeat&&allowedPassword&&allowedLogin){
            readyBut.disabled = false;
        }else{
            readyBut.disabled=true;
        }
    }

</script>