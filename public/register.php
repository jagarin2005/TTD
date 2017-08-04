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
    $role = "user";
    
    if($email==""){
      $error[] = "กรุณาใส่อีเมล์ของคุณ";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = "กรุณาใส้อีเมล์ของคุณให้ถูกต้อง";
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
    else if(strlen($pwd) < 8 || strlen($pwe) < 8) {
      $error[] = "รหัสผ่านต้องมีมากกว่า 8 ตัวอักษร";
    }
    else if($pwd!=$pwe) {
      $error[] = "กรุณาใส่รหัสผ่านให้ตรงกัน";
    }else{
      try{
        $stmt = $conn->prepare("SELECT uemail, uname FROM user WHERE uemail=:email OR uname=:name");
        $stmt->execute(array(":email"=>$email, ":name"=>$uname));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row['uemail'] == $email) {
          $error[] = "อีเมล์นี้ถูกใช้ไปแล้ว";
        }
        else {
          if($user->register($email, $name, $pwd, $role)) {
            $user->redirect("/p/login");
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
                <div class="form-group row">
                  <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="text" name="name" value="" placeholder="ชื่อ - นามสกุล" required>
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="email" name="eml" value="" placeholder="อีเมล์" required>
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="password" name="pwd" id="pwd" value="" placeholder="รหัสผ่าน" onkeyup="check_pass()" required>
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <label for="" class="col-md-2 col-form-label">Text1</label> -->
                  <div class="col-12">
                    <input class="form-control form-control-lg" type="password" name="pwe" id="pwe" value="" placeholder="ยืนยันรหัสผ่าน" onkeyup="check_pass()" required>
                  </div>
                </div>
                <p></p>
                <div class="row justify-content-center">
                  <button type="submit" class="btn btn-primary btn-lg col-5" name="reg-btn" value="true">ลงทะเบียน</button>
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
        document.getElementById("pwd").style.borderColor = "#d9d9d9";
        document.getElementById("pwe").style.borderColor = "#d9d9d9";
      }
      else if(pd != pe || pe == "") {
        document.getElementById("pwd").style.borderColor = "#fe3269";
        document.getElementById("pwe").style.borderColor = "#fe3269";
      }
      else if(pd.length < 8 || pe.length < 8) {
        document.getElementById("pwd").style.borderColor = "#fe3269";
        document.getElementById("pwe").style.borderColor = "#fe3269";
      }
      else if(pd == pe && pd != "" && pe != "") {
        document.getElementById("pwd").style.borderColor = "#32fe69";
        document.getElementById("pwe").style.borderColor = "#32fe69";
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