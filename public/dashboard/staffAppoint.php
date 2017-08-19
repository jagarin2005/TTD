<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
  }
  
  if(isset($_GET["q"]) && isset($_GET["w"])){
    $id = $_GET["w"];
    if($_GET["q"] == "true"){
      $status = "ยืนยันแล้ว";
      $uid = $_GET["u"];
      $sid = $_GET["s"];
      $stmt = $conn->prepare("UPDATE booking SET booking_status=:status WHERE booking_id = :id");
      $stmt->execute(array(":status"=>$status,":id"=>$id));
      $stmt2 = $conn->prepare("INSERT checklist(user_id, staff_id, booking_id) VALUE (:uid,:sid,:bookid)");
      $stmt2->execute(array(":uid"=>$uid,":sid"=>$sid,":bookid"=>$id));
    }else if($_GET["q"] == "false"){
      $status = "ยกเลิกการจอง";
      $stmt = $conn->prepare("UPDATE booking SET booking_status=:status WHERE booking_id = :id");
      $stmt->execute(array(":status"=>$status,":id"=>$id));
    }
    unset($q);
    unset($w);
    $user->redirect("/p/staffAppoint");
    exit();
  }

  if(isset($_POST["cid"])) {
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

?>
<!DOCTYPE html>
<html>
<?php include_once("../template/head.php"); ?>
<body>
  <?php include_once("../template/navbar.php"); ?>
  <div class="container-fluid">
		<div class="row d-flex d-md-block flex-nowrap wrapper mt-5">
				
			<?php include_once("../template/dashboard/sidebar.php"); ?>
			
			<main class="col-12 col-sm-12 col-md-9 col-lg-10 float-left px-5 pl-md-2 pt-2 main">
				<a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
				<div class="page-header">
					<h1>การนัดและการจอง</h1>
        </div>
        <!-- <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#calendar"><i class=""></i></button> -->
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="shifts_table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>ประเภท</th>
                        <th>ผุ้ใช้</th>
                        <th>วันที่</th>
                        <th>โน๊ต</th>
                        <th>สถานะ</th>
                        <th></th>
                      </tr></thead><tbody>';
              $id = $_SESSION["id"];
              $stmt = $conn->prepare("SELECT u.user_id, s.staff_id, b.booking_type, b.booking_id, u.user_name, s.staff_name, b.booking_date, b.booking_note, b.booking_status
                                      FROM `booking` b
                                      INNER JOIN `staff` s ON s.staff_id = b.staff_id
                                      INNER JOIN `user` u ON u.user_id = b.user_id
                                      WHERE s.user_id = :id");
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["booking_type"] .'</td>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["booking_status"] .'</td>
                        <td class="text-center">';
                        if($row["booking_status"] == 'รอการยืนยัน'){echo '<a class="" href="/p/staffAppoint?q=true&w='.$row["booking_id"].'&u='.$row["user_id"].'&s='.$row["staff_id"].'" data-toggle="tooltip" data-placement="top" title="ทำการยืนยัน"><i class="fa fa-check fa-fw text-success"></i></a>
                                                                        <a class="" href="/p/staffAppoint?q=false&w='.$row["booking_id"].'" data-toggle="tooltip" data-placement="top" title="ยกเลิกการจอง"><i class="fa fa-close fa-fw text-danger"></i></a>';}
                        echo '</td>
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

	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#shifts_table').DataTable();
    });
  </script>
</body>
</html>
<?php $conn = null ?>