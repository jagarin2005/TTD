<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
	if(!$user->is_staff()){
    $user->redirect("/");
  }
  require_once("../template/navbarFunction.php");
  $stmtStaff = $conn->prepare("SELECT * FROM staff WHERE user_id = :uid");
  $stmtStaff->bindParam(":uid", $_SESSION["id"]);
  $stmtStaff->execute();
  $rowStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC);

  // Update checklist
  if(isset($_POST["isUpdateCheck"], $_POST["cid"])) {
    $cid = $_POST["cid"];
    $status = $_POST["check_status"];
    $stmt = $conn->prepare("SELECT * 
                            FROM checklist c
                            INNER JOIN booking b ON b.booking_id = c.booking_id
                            INNER JOIN staff s ON s.staff_id = c.staff_id
                            INNER JOIN user u ON u.user_id = c.user_id
                            WHERE checklist_id=:cid
                          ");
    $stmt->execute(array(":cid"=>$cid));
    $rowUpdate=$stmt->fetch(PDO::FETCH_ASSOC);
    if($cid != '') {
      try{
        $updateCheck = $conn->prepare("UPDATE checklist SET check_status = :status, checklist_note = :note WHERE checklist_id = :id");
        $updateCheck->execute(array(":status"=>$status, ":note"=>$_POST["checklist_note"], ":id"=>$rowUpdate["checklist_id"]));
        $check = $conn->prepare("SELECT check_status FROM checklist WHERE checklist_id = :id");
        $check->execute(array(":id"=>$cid));
        $result = $check->fetch(PDO::FETCH_ASSOC);
        if($result["check_status"] != ''){
          $insScore = $conn->prepare("INSERT INTO scorelog(staff_id, user_id, booking_id, checklist_id) VALUES (:staff,:user,:booking,:checklist)");
          $insScore->execute(array(":staff"=>$rowUpdate["staff_id"], ":user"=>$rowUpdate["user_id"], ":booking"=>$rowUpdate["booking_id"], ":checklist"=>$rowUpdate["checklist_id"] ));
          // mail to user for rating staff
          $stmtStaff = $conn->prepare("SELECT b.booking_date,s.staff_name,u.user_email FROM checklist c INNER JOIN staff s ON s.staff_id = c.staff_id INNER JOIN user u ON u.user_id = c.user_id INNER JOIN booking b ON b.booking_id = c.booking_id WHERE c.checklist_id = :cid");
          $stmtStaff->bindParam(":cid", $cid);
          $stmtStaff->execute();
          $rowStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC);
          $subject = "ขอความกรุณาให้คะแนนความพึงพอใจ || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
          $body = "
          <p>ขอบคุณที่มาใช้บริการกับทางคลินิกฯ</p>
          <br>
                <p>วันที่: ".$rowStaff["booking_date"]."</p>
                <p>เจ้าหน้าที่: ".$rowStaff["staff_name"]."</p>
                <hr><br>
                
                <p>ขอความกรุณาให้คะแนนความพึงพอใจและคำติชมได้ทางเว็บไซต์ของเรา</p>
                <p>ขอบคุณที่ใช้บริการค่ะ</p>
          ";
          $mailer = new Mailer;
          $mailer->send($rowUpdate["user_email"], $subject, $body);
        }
        unset($_POST["cid"]);
        unset($_POST["isUpdateCheck"]);
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }
  }

  // add appointment
  if(isset($_POST["isAddAppoint"], $_POST["uid"], $_POST["sid"])) {
    $uid = $_POST["uid"];
    $sid = $_POST["sid"];
    $cid2 = $_POST["cid2"];
    $note = $_POST["noteAppoint"];
    $date = $_POST["dateAppoint"];
    $type = "นัด";
    $status = "ยืนยันแล้ว";
    $cstatus = "นัดหมายแล้ว";

    if($date != ''){
      if($uid != '' && $sid != '') {
        try{
          $updateoChecklist = $conn->prepare("UPDATE checklist SET check_status = :cstatus WHERE checklist_id = :cid2");
          $updateoChecklist->execute(array(":cstatus"=>$cstatus, ":cid2"=>$cid2));
          $insAppoint = $conn->prepare("INSERT INTO booking(user_id, staff_id, booking_date, booking_note, booking_status, booking_type) VALUES (:uid, :sid, :date, :note, :status, :type)");
          $insAppoint->execute(array(":uid"=>$uid, ":sid"=>$sid, ":date"=>$date, ":note"=>$note, ":status"=>$status, ":type"=>$type));
          $checkBooking = $conn->prepare("SELECT booking_id FROM booking WHERE user_id = :uid AND staff_id = :sid AND booking_date = :date");
          $checkBooking->execute(array(":uid"=>$uid, ":sid"=>$sid, ":date"=>$date));
          $rowCheckBooking = $checkBooking->fetch(PDO::FETCH_ASSOC);
          $insChecklist = $conn->prepare("INSERT INTO checklist(user_id, staff_id, booking_id) VALUES (:uid, :sid, :booking_id)");
          $insChecklist->execute(array(":uid"=>$uid, ":sid"=>$sid, ":booking_id"=>$rowCheckBooking["booking_id"]));
          unset($_POST["isAddAppoint"]);
          unset($_POST["uid"]);
          unset($_POST["sid"]);
          unset($_POST["cid"]);
          unset($_POST["noteAppoint"]);
          unset($_POST["dateAppoint"]);
          unset($uid, $sid, $cid2, $note, $date, $type, $status, $cstatus);
        }catch(PDOException $e) {
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
			
			<main class="col-12 col-sm-12 col-md-9 col-lg-10 float-left px-5 pl-md-2 pt-2 main">
				<a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
				<div class="page-header">
					<h1>บันทึกการรักษา</h1>
				</div>
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="booking_table" class="table table-striped table-bordered table-responsive table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>จองวันที่</th>                      
                        <th>ผู้ใช้</th>
                        <th>อาการ</th>
                        <th>การรักษา</th>
                        <th>ผลการรักษา</th>
                        <th></th>
                      </tr></thead><tbody>';
                      $id = $_SESSION["staff"];
              $stmt = $conn->prepare("SELECT u.user_id, u.user_name, s.staff_id, b.booking_id, c.checklist_id, c.checklist_note, c.check_status, b.booking_date, b.booking_note, b.booking_status, b.booking_type
                                      FROM checklist c
                                      LEFT JOIN booking b ON b.booking_id = c.booking_id
                                      INNER JOIN staff s ON s.staff_id = c.staff_id
                                      INNER JOIN user u ON u.user_id = c.user_id
                                      WHERE c.staff_id = :id");
                                      
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["checklist_note"] .'</td>
                        <td>'. $row["check_status"] .'</td>
                        <td class="text-center">';
                          if($row["check_status"] == ''){echo '<a class="badge badge-info text-white" href="" data-toggle="modal" data-target="#e_check" data-id="'.$row["checklist_id"].'" data-name="'.$row["user_name"].'" data-date="'.$row["booking_date"].'" data-note="'.$row["booking_note"].'"><i class="fa fa-pencil fa-fw" data-toggle="tooltip" data-placement="right" title="บันทึกการรักษา"></i> บันทึกการรักษา</a>';}
                          if($row["check_status"] == 'นัดหมายการรักษาครั้งต่อไป'){echo '<a class="badge badge-primary text-white" href="" data-toggle="modal" data-target="#add_appoint" data-uid="'.$row["user_id"].'" data-sid="'.$row["staff_id"].'" data-cid2="'.$row["checklist_id"].'"><i class="fa fa-asterisk fa-fw" data-toggle="tooltip" data-placement="right" title="นัดหมายครั้งต่อไป"></i> นัดหมาย</a>';}
                          if($row["check_status"] == 'การรักษาเสร็จสิ้น'){echo '<a class="badge badge-success text-white" title="การรักษาเสร็จสิ้น"><i class="fa fa-check fa-fw"></i> การรักษาเสร็จสิ้น</a>';}
                          if($row["check_status"] == 'นัดหมายแล้ว'){echo '<a class="badge badge-success text-white" title="นัดหมายแล้ว"><i class="fa fa-check fa-fw"></i> นัดหมายแล้ว</a>';}
                          if($row["check_status"] == 'ยกเลิกการนัดหมาย'){echo '<a class="badge badge-danger text-white" title="ยกเลิกการนัดหมาย"><i class="fa fa-check fa-fw"></i> ยกเลิกการนัดหมาย</a>';}                          
                  echo '</td></tr>';
              }
              echo '   </tbody>
                  </table>
                ';
            ?>
          </div>
          <div class="col-md-12">

          </div>
				</div>
			</main>
		</div>
  </div>

  <!-- Edit checklist Modal -->
  <div class="modal fade" id="e_check" tabindex="-1" role="dialog" aria-labelledby="updateCheck">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateCheck">Edit Check</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form id="updateCheckForm" name="updateCheck" method="post" action="">
            <div class="form-group row" id="user">
              <div class="col-12">
                <input type="text" class="form-control" name="user_name" id="checkName" placeholder="ผู้ใช้" value="" disabled>
              </div>
            </div>
            <div class="form-group row" id="book_date">
              <div class="col-12">
                <input type="date" class="form-control" name="book_date" id="checkDate" placeholder="วันที่จอง" value="" disabled>
              </div>
            </div>
            <div class="form-group row" id="book_note">
              <div class="col-12">
                <textarea rows="3" cols="" class="form-control" name="book_note" id="checkNote" placeholder="อาการ" disabled></textarea>
              </div>
            </div>
            <div class="form-group row" id="check_status">
              <div class="col-12">
                <select class="form-control" name="check_status" value="">
                  <option value="การรักษาเสร็จสิ้น">การรักษาเสร็จสิ้น</option>
                  <option value="นัดหมายการรักษาครั้งต่อไป">นัดหมายการรักษาครั้งต่อไป</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="checklist_note">
              <div class="col-12">
                <textarea rows="3" cols="" class="form-control" name="checklist_note" placeholder="รายละเอียด"></textarea>
              </div>
            </div>
            <input type="hidden" name="isUpdateCheck" value="true">
            <input type="hidden" name="cid" id="cid" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="updateCheckForm" class="btn btn-primary">Edit Check</button>
        </div>
      </div>
    </div>
  </div>

  <!-- add appointment -->
  <div class="modal fade" id="add_appoint" tabindex="-1" role="dialog" aria-labelledby="addAppointment">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAppointment">Add Appointment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" name="addAppoint" id="addAppointForm">
            <div class="form-group">
              <select class="form-control" name="dateAppoint" value="" requires>
                <option value="" selected>วันที่ทำการนัด</option>
                <?php 
                $stmtDate = $conn->prepare("SELECT * FROM shifts WHERE staff_id = :sid AND s_date > :now ORDER BY s_date ASC");
                $stmtDate->bindParam(":sid", $rowStaff["staff_id"]);
                $stmtDate->bindParam(":now", date("Y-m-d", strtotime("+1 day")));         
                $stmtDate->execute();
                while($rowDate = $stmtDate->fetch(PDO::FETCH_ASSOC)){
                  echo '<option>'.$rowDate["s_date"].'</option>';
                } 
                ?>
              </select>
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="3" cols="" name="noteAppoint" placeholder="อาการหรือหมายเหตุ..."></textarea>
            </div>
            <input type="hidden" name="isAddAppoint" value="true">
            <input type="hidden" name="uid" id="uid" value="">
            <input type="hidden" name="sid" id="sid" value="">
            <input type="hidden" name="cid2" id="cid2" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="addAppointForm" class="btn btn-primary">Add Appoint</button>
        </div>
      </div>
    </div>
  </div>
  
	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#booking_table').DataTable();
    });
    $('#e_check').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var name = button.data('name')
      var date = button.data('date')
      var note = button.data('note')
      var modal = $(this)
      modal.find('#cid').val(id)
      modal.find('#checkName').val(name)
      modal.find('#checkDate').val(date)
      modal.find('#checkNote').val(note)
    });
    $('#add_appoint').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var uid = button.data('uid')
      var sid = button.data('sid')
      var cid2 = button.data('cid2')
      var modal = $(this)
      modal.find('#uid').val(uid)
      modal.find('#sid').val(sid)
      modal.find('#cid2').val(cid2)
    })
  </script>
</body>
</html>
