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
            <h3 class="card-title py-3 text-center"><i class="fa fa-id-card-o"></i> สมัครสมาชิก</h3>
            <form method="post" action="" name="register">
              <div class="form-group row">
                <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="text" name="name" value="" placeholder="ชื่อ - นามสกุล" required>
                </div>
              </div>
              <div class="form-group row">
                <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="email" name="eml" value="" placeholder="อีเมล์" required>
                </div>
              </div>
              <div class="form-group row">
                <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="password" name="pwd" id="pwd" value="" placeholder="รหัสผ่าน" onkeyup="check_pass()" required>
                </div>
              </div>
              <div class="form-group row">
                <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                <div class="col-md-12">
                  <input class="form-control form-control-lg" type="password" name="pwe" id="pwe" value="" placeholder="ยืนยันรหัสผ่าน" onkeyup="check_pass()" required>
                </div>
              </div>
              <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg col-5">ลงทะเบียน</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('./template/footer.php') ?>
  <script>
    function check_pass() {
      var pd = document.forms["register"]["pwd"].value;
      var pe = document.forms["register"]["pwe"].value;
      if(pd== "" && pe == "") {
        document.getElementById("pwd").style.borderColor = "#d9d9d9";
        document.getElementById("pwe").style.borderColor = "#d9d9d9";
      }
      else if(pd == pe) {
        document.getElementById("pwd").style.borderColor = "#32fe69";
        document.getElementById("pwe").style.borderColor = "#32fe69";
      }
      else if(pd != pe || pe == "") {
        document.getElementById("pwd").style.borderColor = "#fe3269";
        document.getElementById("pwe").style.borderColor = "#fe3269";
      }
    }
  </script>
</body>

</html>