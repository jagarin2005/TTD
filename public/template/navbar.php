<!-- Navbar  -->
<?php include_once('../config/conn.php'); ?>
<?php 
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["isLogout"] == true){
      $user->logout();
      $user->redirect("/p/");
    }
  }
?> 
<nav class="navbar navbar-toggleable-md bg-faded navbar-light fixed-top" role="navbar">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
  </button>
  <a class="navbar-brand hidden-lg-up">Menu</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/p/">หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">สินค้า</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">บริการ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">กิจกรรมของเรา</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">เกี่ยวกับคลินิกฯ</a>
      </li>
    </ul>
    <hr class="col-12 hidden-lg-up">
    <ul class="navbar-nav">
    <?php 
    if($user->is_loggedin()) {
      echo '
      <li class="nav-item px-1">
        <a class="nav-link"><i class="fa fa-user"></i> '. $_SESSION["user"] .'</a>
      </li>
      <li class="nav-item px-1">
        <a class="nav-link" href="/p/dashboard"><i class=""></i> ทำการจอง</a>
      </li>
      <li class="nav-item px-1">
        <form method="post" action="" id="logout">
          <button class="nav-link btn btn-link" type="submit"><i class="fa fa-sign-out"></i> Logout</button>
          <input type="hidden" name="isLogout" value="true" />
        </form>
      </li>
      ';
      
    }else{ 
      echo '
      <li class="nav-item">
        <a class="nav-link" href="/p/register"><i class="fa fa-id-card-o" aria-hidden="true"></i> สมัครสมาชิก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/login"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</a>
      </li> ';
    }
    ?>
    </ul>
  </div>
</nav>