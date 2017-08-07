<?php include_once("../../config/conn.php"); ?>
<?php 

  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
	if($user->is_staff()){
    $user->redirect("/p/dashboard");
    exit();
  }
  if($user->is_user()){
    $user->redirect("/p/");
  }

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isAddUser"])) {
      $email = trim($_POST["uemail"]);
      $name = trim($_POST["uname"]);
      $pwd = trim($_POST["upwd"]);
      $tel = trim($_POST["utel"]);
      $sex = trim($_POST["usex"]);
      $role = trim($_POST["utype"]);
      
      if($email==""){
        $error[] = "กรุณาใส่อีเมล์ของคุณ";
      }else if($role=="") {
        $error[] = "กรุณาใส่ประเภทผู้ใช้";
      }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "กรุณาใส่อีเมล์ของคุณให้ถูกต้อง";
      }
      else if($name==""){
        $error[] = "กรุณาใส่ชื่อของคุณ";
      }
      else if($pwd==""){
        $error[] = "กรุณาใส่รหัสผ่านของคุณ";
      }
      else if(strlen($pwd) < 6) {
        $error[] = "รหัสผ่านต้องมีมากกว่า 6 ตัวอักษร";
      }else{
        try{
          $stmt = $conn->prepare("SELECT user_email, user_name FROM user WHERE user_email=:email");
          $stmt->execute(array(":email"=>$email));
          $row=$stmt->fetch(PDO::FETCH_ASSOC);

          if($row['user_email'] == $email) {
            $error[] = "อีเมล์นี้ถูกใช้ไปแล้ว";
          }
          else {
            if($user->register($email, $name, $pwd, $role, $tel, $sex)) {
              $user->redirect("/p/manageUser");
              $email = null;
              $name = null;
              $pwd = null;
              $tel = null;
              $sex = null;
              $role = null;
              exit();
            }
          }
        }catch(PDOException $e){
          echo $e->getMessage();
        }
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
          <h1>การจัดการผู้ใช้</h1>
        </div>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"> Add</i></button>
				<p class="lead"><?php if(isset($error)){foreach($error as $k=>$v){echo $v;}} ?></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="user_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Tel</th>
                        <th>Sex</th>
                      </tr></thead>
                      <tbody>';
              $stmt = $conn->prepare("SELECT * FROM user");
              $stmt->execute();
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["user_id"] .'</td>
                        <td>'. $row["user_email"] .'</td>
                        <td>'. $row["user_role"] .'</td>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["user_tel"] .'</td>
                        <td>'. $row["user_sex"] .'</td>
                      </tr>';
              }
              echo '   </tbody>
                  </table>
                ';
            ?>
					</div>
				</div>
			</main>
		</div>
  </div>
  
  <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="addUser">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUser">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="post" action="" name="addUser" id="addUserForm">
            <div class="form-group row" id="u_email">
              <div class="col-12">
                <input type="email" class="form-control form-control-lg" name="uemail" placeholder="อีเมล์">
              </div>
            </div>
            <div class="form-group row" id="u_pwd">
              <div class="col-12">
                <input type="password" class="form-control form-control-lg" name="upwd" placeholder="รหัสผ่าน">
              </div>
            </div>
            <div class="form-group row" id="u_type">
              <div class="col-12">
                <select class="form-control form-control-lg" name="utype">
                  <option selected>ประเภทผู้ใช้</option>
                  <option value="staff">เจ้าหน้าที่</option>
                  <option value="user">ผู้ใช้</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="u_name">
              <div class="col-12">
                <input type="text" class="form-control form-control-lg" name="uname" placeholder="ชื่อ - นามสกุล">
              </div>
            </div>
            <div class="form-group row" id="u_tel">
              <div class="col-12">
                <input type="tel" class="form-control form-control-lg" name="utel" placeholder="เบอร์โทรฯ">
              </div>
            </div>
            <div class="text-center">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="usex" id="sex" value="ชาย" checked> เพศชาย <i class="fa fa-male"></i>
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="usex" id="sex" value="หญิง"> เพศหญิง <i class="fa fa-female"></i>
                </label>
              </div>
            </div>
            <input type="hidden" name="isAddUser" value="true">
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="addUserForm" class="btn btn-primary">Add User</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php include_once("../template/footer.js.php"); ?>
  <script>
    $(document).ready(function() {
      $('#user_table').DataTable();
    });
  </script>
</body>
</html>
