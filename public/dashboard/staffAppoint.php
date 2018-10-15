<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
    $user->redirect("/");
    exit;
  }
  if(!$user->is_staff()) {
    $user->redirect("/");
    exit;
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["con"])){
    $uid = $_POST["uid"];
    $sid = $_POST["sid"];
    $bid = $_POST["bid"];
    $stmtStaff = $conn->prepare("SELECT b.booking_date,s.staff_name,u.user_email FROM booking b INNER JOIN staff s ON s.staff_id = b.staff_id INNER JOIN user u ON u.user_id = b.user_id WHERE b.booking_id = :bid");
    $stmtStaff->bindParam(":bid", $bid);
    $stmtStaff->execute();
    $rowStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC);
    if($_POST["con"] == "true"){
      $status = "ยืนยันแล้ว";
      $stmt = $conn->prepare("UPDATE booking SET booking_status=:status WHERE booking_id = :id");
      $stmt->execute(array(":status"=>$status,":id"=>$bid));
      $stmt2 = $conn->prepare("INSERT checklist(user_id, staff_id, booking_id) VALUE (:uid,:sid,:bookid)");
      $stmt2->execute(array(":uid"=>$uid,":sid"=>$sid,":bookid"=>$bid));
      $subject = "เจ้าหน้าที่ได้ทำการยืนยันการจองของคุณแล้ว || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
      $body = "
      <p>เจ้าหน้าที่ได้ทำการยืนยันการจองของคุณแล้ว</p>
      <br>
            <p>วันที่: ".$rowStaff["booking_date"]."</p>
            <p>เจ้าหน้าที่: ".$rowStaff["staff_name"]."</p>
            <hr><br>
            
            <p>ท่านสามารถเข้ารับบริการได้ในวันที่ดังกล่าว</p>
      ";
      $mailer = new Mailer;
      $mailer->send($rowStaff["user_email"], $subject, $body);
    }else if($_POST["con"] == "false"){
      $status = "ยกเลิกการจอง";
      $stmt = $conn->prepare("UPDATE booking SET booking_status=:status WHERE booking_id = :id");
      $stmt->execute(array(":status"=>$status,":id"=>$bid));
      $subject = "การจองถูกยกเลิก || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
      $body = "
      <p>การจองของท่านถูกยกเลิก</p>
      <br>
            <p>วันที่: ".$rowStaff["booking_date"]."</p>
            <p>เจ้าหน้าที่: ".$rowStaff["staff_name"]."</p>
            <p>เนื่องจากเจ้าหน้าที่ไม่สะดวกในการให้บริการในวันดังกล่าว</p>
            <hr><br>
            
            <p>ขออภัยในความไม่สะดวกค่ะ</p>
      ";
      $mailer = new Mailer;
      $mailer->send($rowStaff["user_email"], $subject, $body);
    }
    unset($_POST["con"],$_POST["bid"],$_POST["sid"],$_POST["uid"],$uid,$sid,$bid);
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
              $id = $_SESSION["staff"];
              $stmt = $conn->prepare("SELECT u.user_id, s.staff_id, b.booking_type, b.booking_id, u.user_name, s.staff_name, b.booking_date, b.booking_note, b.booking_status
                                      FROM `booking` b
                                      INNER JOIN `staff` s ON s.staff_id = b.staff_id
                                      INNER JOIN `user` u ON u.user_id = b.user_id
                                      WHERE b.staff_id = :id");
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["booking_type"] .'</td>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["booking_status"] .'</td>
                        <td class="text-center">';
                        if($row["booking_status"] == 'รอการยืนยัน'){echo '<a class="badge badge-warning text-light" href="#" data-toggle="modal" data-target="#con_appoint" data-uid="'.$row["user_id"].'" data-sid="'.$row["staff_id"].'" data-bid="'.$row["booking_id"].'"><i class="fa fa-check-circle-o fa-fw"></i> จอง</a>';}
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

  
  <div class="modal fade" id="con_appoint" tabindex="-1" role="dialog" aria-labelledby="conAppoint">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="conAppoint">Confirm Appointment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-fw"></i></button>
        </div>
        <div class="modal-body">
          <form method="post" action="" name="conAppoint" id="conAppointForm">
            <p>คุณต้องการยืนยันการจองนี้ใช่หรือไม่</p>
            <input type="hidden" name="isConAppoint" value="true">
            <input type="hidden" name="bid" id="bid" value="">
            <input type="hidden" name="uid" id="uid" value="">
            <input type="hidden" name="sid" id="sid" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="con" form="conAppointForm" class="btn btn-danger" value="false">Refuse</button>
          <button type="submit" name="con" form="conAppointForm" class="btn btn-primary" value="true">Confirm</button>
        </div>
      </div>
    </div>
  </div>

	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#shifts_table').DataTable();
    });
    $('#con_appoint').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var uid = button.data('uid')
      var sid = button.data('sid')
      var bid = button.data('bid')
      var modal = $(this)
      modal.find('#uid').val(uid)
      modal.find('#sid').val(sid)
      modal.find('#bid').val(bid)
    })
  </script>
</body>
</html>
<?php $conn = null ?>