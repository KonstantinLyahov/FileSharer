<? 
  session_start();
  header('Content-type: text/html; charset=utf-8');
  header('Location: download.php');
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
        
      </div>
    </div>
  </section>
</body>
</html>