<!-- Navbar Dashboard  -->

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
    <ul class="navbar-nav">
    <?php 
    if(!isset($_SESSION["user"])) { echo '
      <li class="nav-item">
        <a class="nav-link" href="/p/register"><i class="fa fa-id-card-o" aria-hidden="true"></i> สมัครสมาชิก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/login"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</a>
      </li> ';
    }else{ echo '
      <li class="nav-item">
        <a class="nav-link"><i class="fa fa-user"></i> $_SESSION["user"]</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick='. $user->logout() .'><i class="fa fa-sign-out"></i>
      </li>
      ';
    }
    ?>
    </ul>
  </div>
</nav>