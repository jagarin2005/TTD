<!-- Navbar -->
<?php 
if($user->is_loggedin()){
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isLogout"])){
      $user->logout();
      $user->redirect("/p/");
    }
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
        <a class="nav-link" href="/p/" id="index_nav">หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#product" id="product_nav">สินค้า</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#service" id="service_nav">บริการ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#contact" id="contact_nav">ติดต่อเรา</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#about" id="about_nav">เกี่ยวกับคลินิกฯ</a>
      </li>
    </ul>
    <hr class="col-12 hidden-lg-up" style="width: 90%;">
    <ul class="navbar-nav">
    <?php 
    if($user->is_loggedin()) {
      echo '
      <li class="nav-item dropdown px-1 hidden-md-down">
        <a class="nav-link dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
          <i class="fa fa-user"></i> '. $_SESSION["name"] .'
        </a>
        <div class="dropdown-menu" aria-labelledby="userMenu">
          <a class="dropdown-item" href="/p/dashboard"><i class=""></i> Dashboard</a>';
          if($user->is_user()) {
            echo '<button class="dropdown-item btn btn-link" type="button" data-toggle="modal" data-target="#modal_1">booking</button>';
          }
          echo '
          <div class="dropdown-divider"></div>
          <form method="post" action="" id="logout">
            <button class="dropdown-item btn btn-link" type="submit"><i class="fa fa-sign-out"></i> Logout</button>
            <input type="hidden" name="isLogout" value="true" />
          </form>
        </div>
      </li>

      <li class="nav-item px-1 hidden-lg-up">
        <a class="nav-link"><i class="fa fa-user"></i> '. $_SESSION["name"] .'</a>
      </li>
      <li class="nav-item px-1 hidden-lg-up">
        <a class="nav-link" href="/p/dashboard"><i class=""></i> Dashboard</a>
      </li>
      <li class="nav-item" px-1 hidden-lg-up">
        <a class="nav-link"></a>
      </li>
      <li class="nav-item px-1 hidden-lg-up">
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

<div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="booking">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="booking">Booking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" action="" name="booking">
          <div class="form-group row" id="med">
            <div class="col-12">
              <select class="form-control form-control-lg" name="med" placeholder="เลือกเจ้าหน้าที่...">
                <?php 
                  
                ?>
              </select>
            </div>
          </div>
          <input type="hidden" name="isBooking" value="true">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" for="booking" class="btn btn-success">Booking</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
