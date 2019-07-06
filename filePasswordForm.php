<? 
  session_start();
  header('Content-type: text/html; charset=utf-8');
  if(isset($_COOKIE["login"])){
    $_SESSION["logged"]=true;
    $_SESSION["login"]=$_COOKIE["login"];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bulma.css">
    <title>FileSharer</title>
</head>
<body>
  <section class="hero is-fullheight is-light is-bold with-navbar">
    <div class="hero-head">
      <?include "components/navbar.php";?>
    </div>
    <div class="hero-body">
      <div class="container has-text-centered">
        введите пароль<br><input class="input is-primary is-small" type="password" style="width:300px" id="passwordInput"><br><br>
        <div class="button is-link" id="readyBut">Готово</div>
        <p class="help has-text-danger" style="display:none" id="err">неправильно</p>
        <script>
            document.getElementById("readyBut").addEventListener("click",()=>{
                let filehash=<?echo "'".$_GET["code"]."'";?>;
                let password=document.getElementById("passwordInput").value;
                const xhr = new XMLHttpRequest();
                xhr.open('GET','php/filePass.php?code='+filehash+'&password='+password, true);
                xhr.send();
                readyBut.className="button is-loading";
                xhr.onreadystatechange = function() {
                    if (xhr.readyState != 4) return;
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                        if(xhr.responseText=="OK"){
                            readyBut.className="button";
                            document.querySelector("#err").style.display="none";
                            location.href="getFile.php?code="+filehash+"&password="+password;
                        }else{
                            readyBut.className="button";
                            document.querySelector("#err").style.display="block";
                        }
                    }
                }
            })
        </script>
      </div>
    </div>
  </section>
</body>
</html>