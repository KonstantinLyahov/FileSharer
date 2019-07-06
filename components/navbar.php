<? session_start();?>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
        <img src="img/logo.jpg">
    </a>
    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarMenu" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href=<?if($_SESSION["logged"])echo"'upload.php'";else echo"'login.php'";?>>
        Загрузить файл
      </a>
      <a class="navbar-item" href="download.php">
        Скачать файл
      </a>
      <?if($_SESSION["logged"]){
          echo "<a class='navbar-item' href='uploaded.php'>Просмотреть загруженные файлы</a>";
        }?>
    </div>

    <div class="navbar-end">
      <?if($_SESSION["logged"]&&$_SESSION["login"]){
          $username=$_SESSION["login"];
          echo "<a class='navbar-item' href='profile.php'><img src='img/user.jpg'><span>$username</span></a>";
        }else{
          echo '<div class="navbar-item"><div class="buttons"><a class="button is-link" href="signup.php"><strong>Зарегестрироваться</strong></a><a class="button is-light" href="login.php">Авторизоваться</a></div></div>';
        }
      ?>
    </div>
  </div>
</nav>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
  if ($navbarBurgers.length > 0) {
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {
        const target = el.dataset.target;
        const $target = document.getElementById(target);
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');  

      });
    });
  }
});
</script>