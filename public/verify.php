<?php include_once("../config/conn.php") ?>
<?php 
    if(isset($_GET["confirm_code"]) && !empty($_GET["confirm_code"]) AND isset($_GET["email"]) && !empty($_GET["email"])) {
      if($user->confirm_email($_GET["email"], $_GET["confirm_code"])) {
        $user->setActivate($_GET["email"], $_GET["confirm_code"]);
        $message = '<p>การยืนยันการสมัครสมาชิกสำเร็จ ท่านสามารถเข้าสู่ระบบได้แล้ว กรุณาไปที่หน้า เข้าสู่ระบบ ขอบคุณที่สละเวลาค่ะ</p>
                    <a href="/p/login">เข้าสู่หน้า Login</a>
                    ';
      }else{
        $message = '<p>การยืนยันอีเมล์เกิดข้อผิดพลาด กรุณาติดต่อกับทางคลินิกหรือลองใหม่อีกครั้งค่ะ</p>
                    <a href="/p/">กลับไปยังหน้าหลัก</a>
                    ';
      }
    }else{
      $user->redirect("/p/");
    }
  if($user->is_loggedin()) {
    $user->redirect("/p/");
  }
?>
<!DOCTYPE html>
<html>
<?php include_once('./template/head.php') ?>
<body>
  <?php include_once('./template/navbar.php') ?>
  <div class="wrapper py-5" style="background: #eceeef;">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-5 col-offset-3">
          <div class="card px-3">
            <div class="card-block">
              <h3 class="card-title py-3 text-center"><i class="fa fa-sign-in"></i> ยืนยันการสมัครสมาชิก</h3>
              <?php echo $message; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('./template/footer.php') ?>
  <?php include_once('./template/footer.js.php') ?>
</body>

</html>