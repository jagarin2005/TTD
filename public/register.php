<?php include_once("../config/conn.php") ?>
<?php
  if($user->is_loggedin()){
    $user->redirect("/p/");
  }
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["eml"]);
    $name = trim($_POST["name"]);
    $pwd = trim($_POST["pwd"]);
    $pwe = trim($_POST["pwe"]);
    $tel = trim($_POST["tel"]);
    $sex = trim($_POST["sex"]);
    $role = "user";
    
    if($email==""){
      $error[] = "กรุณาใส่อีเมล์ของคุณ";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = "กรุณาใส่อีเมล์ของคุณให้ถูกต้อง";
    }
    else if($name==""){
      $error[] = "กรุณาใส่ชื่อของคุณ";
    }
    else if($pwd==""){
      $error[] = "กรุณาใส่รหัสผ่านของคุณ";
    }
    else if($pwe==""){
      $error[] = "กรุณายืนยันรหัสผ่านของคุณ";
    }
    else if(strlen($pwd) < 6 || strlen($pwe) < 6) {
      $error[] = "รหัสผ่านต้องมีมากกว่า 8 ตัวอักษร";
    }
    else if($pwd!=$pwe) {
      $error[] = "กรุณาใส่รหัสผ่านให้ตรงกัน";
    }else{
      try{
        $stmt = $conn->prepare("SELECT user_email, user_name FROM user WHERE user_email=:email OR user_name=:name");
        $stmt->execute(array(":email"=>$email, ":name"=>$name));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row['user_email'] == $email) {
          $error[] = "อีเมล์นี้ถูกใช้ไปแล้ว";
        }
        else {
          if($user->register($email, $name, $pwd, $role, $tel, $sex)) {
            $user->redirect("/p/");
          }
        }
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }
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
              <h3 class="card-title py-3 text-center"><i class="fa fa-id-card-o"></i> สมัครสมาชิก</h3>
              <form method="post" action="" name="register">
                <div class="form-group row" id="name_">
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="text" name="name" value="" placeholder="ชื่อ - นามสกุล" required>
                  </div>
                </div>
                <div class="form-group row" id="email_">
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="email" name="eml" value="" placeholder="อีเมล์" required>
                  </div>
                </div>
                <div class="form-group row" id="pwd_">
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="password" name="pwd" id="pwd" value="" placeholder="รหัสผ่าน" onkeyup="check_pass()" required>
                  </div>
                </div>
                <div class="form-group row" id="pwe_">
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="password" name="pwe" id="pwe" value="" placeholder="ยืนยันรหัสผ่าน" onkeyup="check_pass()" required>
                  </div>
                </div>
                <div class="form-group row" id="tel_">
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="tel" name="tel" id="tel" value="" placeholder="เบอร์โทรศัพท์">
                  </div>
                </div>
                <div class="text-center">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="sex" id="sex" value="0"> เพศชาย <i class="fa fa-male"></i>
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="sex" id="sex" value="1"> เพศหญิง <i class="fa fa-female"></i>
                    </label>
                    </div>
                  </div>
                <p></p>
                <div class="row justify-content-center">
                  <button type="submit" class="btn btn-primary btn-lg col-11" name="reg-btn" value="true">ลงทะเบียน</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('./template/footer.php') ?>
  <script>
    var pass = false;
    function check_pass() {
      var pd = document.forms["register"]["pwd"].value;
      var pe = document.forms["register"]["pwe"].value;
      if(pd == "" && pe == "") {
        $("#pwd_").removeClass("has-danger");
        $("#pwe_").removeClass("has-danger");
        $("#pwd").removeClass("form-control-danger");
        $("#pwe").removeClass("form-control-danger");
        $("#pwd_").removeClass("has-success");
        $("#pwe_").removeClass("has-success");
        $("#pwd").removeClass("form-control-success");
        $("#pwe").removeClass("form-control-success");
      }
      else if(pd != pe || pe == "") {
        $("#pwd_").addClass("has-danger");
        $("#pwe_").addClass("has-danger");
        $("#pwd").addClass("form-control-danger");
        $("#pwe").addClass("form-control-danger");
        
      }
      else if(pd.length < 8 || pe.length < 8) {
        $("#pwd_").addClass("has-danger");
        $("#pwe_").addClass("has-danger");
        $("#pwd").addClass("form-control-danger");
        $("#pwe").addClass("form-control-danger");
      }
      else if(pd == pe && pd != "" && pe != "") {
        $("#pwd_").removeClass("has-danger");
        $("#pwe_").removeClass("has-danger");
        $("#pwd").removeClass("form-control-danger");
        $("#pwe").removeClass("form-control-danger");
        $("#pwd_").addClass("has-success");
        $("#pwe_").addClass("has-success");
        $("#pwd").addClass("form-control-success");
        $("#pwe").addClass("form-control-success");
        pass = true;
      }
    }

    document.forms["register"]["reg-btn"].addEventListener("click", function(e) {
      if(pass === false) e.preventDefault()
    });
    document.forms["register"].addEventListener("submit", function(e) {
      if(pass === false) e.preventDefault()
    });
  </script>
</body>

</html>