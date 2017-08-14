<?php include_once("../config/conn.php") ?>
<?php 
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["eml"];
    $password = $_POST["pwd"];
    if($user->login($email, $password)) {
      $user->redirect("/p/");
      exit();
    }else{
      $error = "อีเมล์หรือรหัสผ่านของคุณไม่ถูกต้อง";
    }
  }
?>
<!DOCTYPE html>
<html>
<?php 
  ob_start();
  include_once('./template/head.php'); 
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "เข้าสู่ระบบ";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<body>
  <?php include_once('./template/navbar.php') ?>
  <div class="wrapper py-5" style="background: #eceeef;">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-5 col-offset-3">
          <div class="card px-3">
            <div class="card-block">
              <h3 class="card-title py-3 text-center"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ</h3>
              <form method="post" action="" name="login">
                <div class="form-group row">
                  <!-- <label for="" class="col-md-3 col-form-label">ชื่อผู้ใช้</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="email" name="eml" value="" placeholder="อีเมล์">
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <label for="" class="col-md-3 col-form-label">รหัสผ่าน</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="password" name="pwd" value="" placeholder="รหัสผ่าน">
                  </div>
                </div>
                <p></p>
                <div class="row justify-content-center">
                  <button type="submit" class="btn btn-primary btn-lg col-11" name="login-btn" value="true">เข้าสู่ระบบ </button>
                </div>
              </form>
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