<?php include_once("../../config/conn.php"); ?>
<?php 

  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
	if($user->is_staff()){
    $user->redirect("/dashboard");
    exit();
  }
  if($user->is_user()){
    $user->redirect("/");
  }

  $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=:uid");
  $stmt->execute(array(":uid"=>$_GET["uid"]));
  $rowUpdate=$stmt->fetch(PDO::FETCH_ASSOC);

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isUpdateUser"])) {
      $email = trim($_POST["uemail"]);
      $name = trim($_POST["uname"]);
      $tel = trim($_POST["utel"]);
      $sex = trim($_POST["usex"]);
      $role = trim($_POST["utype"]);
        try{
          $stmt = $conn->prepare("SELECT user_email, user_name FROM user WHERE user_email=:email");
          $stmt->execute(array(":email"=>$email));
          $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($user->update($_GET["uid"], $email, $name, $role, $tel, $sex)) {
              $user->redirect("/manageUser");
              exit();
            }
        }catch(PDOException $e){
          echo $e->getMessage();
        }
      }
    }
?>
<!DOCTYPE html>
<html>
<?php include_once("../template/head.php"); ?>
<body>
  <?php include_once("../template/navbar.php"); ?>
  <div class="container-fluid">
		<div class="row d-flex d-md-block flex-nowrap wrapper mt-5">
				
			<?php include_once("../template/dashboard/sidebar.php"); ?>
			
			<main class="col-md-9 float-left col px-5 pl-md-2 pt-2 main">
				<a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
				<div class="page-header">
          <h1>แก้ไขข้อมูลผู้ใช้</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/manageUser">การจัดการผู้ใช้</a></li>
            <li class="breadcrumb-item active">แก้ไขผู้ใช้</li>
          </ol>
        </div>
				<hr>
				<div class="row">
					<div class="col-md-12 mx-5 px-5">
            <form method="post" action="" name="addUser" id="addUserForm">
            <div class="form-group row" id="u_email">
              <div class="col-12">
                <input type="email" class="form-control form-control-lg" name="uemail" placeholder="อีเมล์" value="<?php echo $rowUpdate["user_email"]; ?>">
              </div>
            </div>
            <div class="form-group row" id="u_name">
              <div class="col-12">
                <input type="text" class="form-control form-control-lg" name="uname" placeholder="ชื่อ - นามสกุล"  value="<?php echo $rowUpdate["user_name"]; ?>">
              </div>
            </div>
            <div class="form-group row" id="u_type">
              <div class="col-12">
                <select class="form-control form-control-lg" name="utype">
                  <option>ประเภทผู้ใช้</option>
                  <option value="staff" <?php if($rowUpdate["user_role"] == 'staff'){ echo 'selected'; } ?>>เจ้าหน้าที่</option>
                  <option value="user" <?php if($rowUpdate["user_role"] == 'user'){ echo 'selected'; } ?>>ผู้ใช้</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="u_tel">
              <div class="col-12">
                <input type="tel" class="form-control form-control-lg" name="utel" placeholder="เบอร์โทรฯ"  value="<?php echo $rowUpdate["user_tel"]; ?>">
              </div>
            </div>
            <div class="text-center">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="usex" id="sex" value="ชาย" <?php if($rowUpdate["user_sex"] == 'ชาย'){ echo 'checked'; } ?>> เพศชาย <i class="fa fa-male"></i>
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="usex" id="sex" value="หญิง" <?php if($rowUpdate["user_sex"] == 'หญิง'){ echo 'checked'; } ?>> เพศหญิง <i class="fa fa-female"></i>
                </label>
              </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" class="btn btn-primary btn-lg col-11" name="updateUser-btn" value="true">แก้ไขข้อมูล</button>
            </div>
            <input type="hidden" name="isUpdateUser" value="true">
          </form>
					</div>
				</div>
			</main>
		</div>
  </div>
  <?php include_once("../template/footer.js.php"); ?>
</body>
</html>
