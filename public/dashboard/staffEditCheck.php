<!-- Error เข้าถึงข้อมูลย้อนหลังได้ -->
<?php include_once("../../config/conn.php"); ?>
<?php 

  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
  if($user->is_user()){
    $user->redirect("/p/");
  }

  if($_GET["q"] == '') {
    $user->redirect('/p/staffCheck');
  }

  $id = $_GET["q"];
  $uid = $_SESSION["id"];
  $stmt = $conn->prepare("SELECT * 
                          FROM checklist c, booking b, staff s, user u
                          WHERE s.staff_id = c.staff_id AND b.booking_id = c.booking_id AND s.user_id = :id AND u.user_id = c.user_id AND checklist_id=:cid");
  $stmt->execute(array(":cid"=>$id,":id"=>$uid));
  $rowUpdate=$stmt->fetch(PDO::FETCH_ASSOC);

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isUpdateCheck"])) {
        try{
          $updateCheck = $conn->prepare("UPDATE checklist SET check_status = :status, checklist_note = :note WHERE checklist_id = :id");
          $updateCheck->execute(array(":status"=>$_POST["check_status"], ":note"=>$_POST["checklist_note"], ":id"=>$rowUpdate["checklist_id"]));
          $check = $conn->prepare("SELECT check_status FROM checklist WHERE checklist_id = :id");
          $check->execute(array(":id"=>$id));
          $result = $check->fetch(PDO::FETCH_ASSOC);
          if($result["check_status"] != ''){
            $insScore = $conn->prepare("INSERT INTO scorelog(staff_id, user_id, booking_id, checklist_id) VALUE (:staff,:user,:booking,:checklist)");
            $insScore->execute(array(":staff"=>$rowUpdate["staff_id"], ":user"=>$rowUpdate["user_id"], ":booking"=>$rowUpdate["booking_id"], ":checklist"=>$rowUpdate["checklist_id"] ));
            $insScore->execute();
          }
          $user->redirect("/p/staffCheck");
          unset($_GET["q"]);
          exit();
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
          <h1>แก้ไขบันทึก</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/p/staffCheck">บันทึกการรักษา</a></li>
            <li class="breadcrumb-item active">แก้ไขบันทึก</li>
          </ol>
        </div>
				<hr>
				<div class="row">
					<div class="col-md-12 mx-5 px-5 pb-5">
            <form method="post" action="" name="updateCheck" id="updateCheckForm">
            <div class="form-group row" id="user">
              <div class="col-12">
                <input type="text" class="form-control form-control-lg" name="user_name" placeholder="ผู้ใช้" value="<?php echo $rowUpdate["user_name"]; ?>" disabled>
              </div>
            </div>
            <div class="form-group row" id="book_date">
              <div class="col-12">
                <input type="date" class="form-control form-control-lg" name="book_date" placeholder="วันที่จอง" value="<?php echo $rowUpdate["booking_date"]; ?>" disabled>
              </div>
            </div>
            <div class="form-group row" id="book_note">
              <div class="col-12">
                <textarea rows="3" cols="" class="form-control form-control-lg" name="book_note" placeholder="อาการ" disabled><?php echo $rowUpdate["booking_note"]; ?></textarea>
              </div>
            </div>
            <div class="form-group row" id="check_status">
              <div class="col-12">
                <select class="form-control form-control-lg" name="check_status" value="">
                  <option value="การรักษาเสร็จสิ้น">การรักษาเสร็จสิ้น</option>
                  <option value="นัดหมายการรักษาครั้งต่อไป">นัดหมายการรักษาครั้งต่อไป</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="checklist_note">
              <div class="col-12">
                <textarea rows="3" cols="" class="form-control form-control-lg" name="checklist_note" placeholder="รายละเอียด"><?php echo $rowUpdate["checklist_note"]; ?></textarea>
              </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" class="btn btn-primary btn-lg col-11" name="updateUser-btn" value="true">แก้ไขข้อมูล</button>
            </div>
            <input type="hidden" name="isUpdateCheck" value="true">
          </form>
					</div>
				</div>
			</main>
		</div>
  </div>
  <?php include_once("../template/footer.js.php"); ?>
</body>
</html>
