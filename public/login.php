<?php include_once("../config/conn.php") ?>
<!DOCTYPE html>
<html>
<?php include_once('./template/head.php') ?>
<body>
  <?php include_once('./template/navbar.php') ?>
  <div class="container my-5 py-5">
    <div class="row justify-content-center">
      <div class="col-md-4 col-offset-3">
        <div class="card">
          <div class="card-block">
            <h3 class="card-title py-3 text-center"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ</h3>
            <form method="post" action="">
              <div class="form-group row">
                <!-- <label for="" class="col-md-3 col-form-label">ชื่อผู้ใช้</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="email" name="eml" value="" placeholder="อีเมล์" required>
                </div>
              </div>
              <div class="form-group row">
                <!-- <label for="" class="col-md-3 col-form-label">รหัสผ่าน</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="password" name="pwd" value="" placeholder="รหัสผ่าน" required>
                </div>
              </div>
              <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg col-5">เข้าสู่ระบบ</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('./template/footer.php') ?>
</body>

</html>