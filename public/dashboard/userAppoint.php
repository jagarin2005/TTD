<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
	if(!$user->is_user()){
    $user->redirect("/dashboard");
  }
  require_once("../template/navbarFunction.php");
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isDelAppoint"])){
      try{
        $id = $_POST["del"];
        // -------- get staff email -------- //
        $stmtStaffMail = $conn->prepare("SELECT s.staff_email, b.booking_date, b.booking_note, u.user_name FROM booking b INNER JOIN staff s ON s.staff_id = b.staff_id INNER JOIN user u ON u.user_id = b.user_id WHERE b.booking_id = :bid LIMIT 1");
        $stmtStaffMail->bindParam(":bid", $id);
        $stmtStaffMail->execute();
        $rowStaffMail = $stmtStaffMail->fetch(PDO::FETCH_ASSOC);
        // -------- delete booking -------- //
        $stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = :id");
        $stmt->execute(array(":id"=>$id));
        // ------- set email message ------ //
        $subject = "ผู้ใช้งานทำการยกเลิกการจองแล้ว || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
        $body = "
        <p>มีผู้ใช้งานได้ทำการยกเลิกการจองเข้ารับบริการ</p>
        <br>
              <p>วันที่: ".$rowStaffMail["booking_date"]."</p>
              <p>ผู้ใช้: ".$rowStaffMail["user_name"]."</p>
              <p>รายละเอียด: ".$rowStaffMail["booking_note"]."</p>
              <hr><br>
              
        ";
        $mailer = new Mailer;
        $mailer->send($rowStaffMail["staff_email"], $subject, $body);
      }catch(PDOException $e){
          echo $e->getMessage();
      }
      unset($id);
      unset($_POST["isDelAppoint"]);
		}

		if(isset($_POST["isPostpone"])){
      $id = trim($_POST["uid"]);
      $select = trim($_POST["select"]);
      $date = trim($_POST["book_date"]);
      $note = trim($_POST["book_note"]);
      $bid2 = trim($_POST["bid2"]);
      $cstatus = "ยกเลิกการนัดหมาย";
      $bstatus = "ยกเลิกแล้ว";
      $status = "รอการยืนยัน";
      $type = "จอง";
      
      if($select == "" || $select == "..."){
        $error[] = "กรุณาเลือกการจอง";
      }else if($date == "") {
        $error[] = "กรุณาใส่วันที่";
      }else{
        try{
          
            $stmtoChecklist = $conn->prepare("SELECT * FROM checklist WHERE booking_id = :bid2");
            $stmtoChecklist->execute(array(":bid2"=>$bid2));
            $rowoChecklist = $stmtoChecklist->fetch(PDO::FETCH_ASSOC);
            $stmtDeloChecklist = $conn->prepare("UPDATE checklist SET check_status = :cstatus WHERE checklist_id = :cid");
            $stmtDeloChecklist->execute(array(":cstatus"=>$cstatus,":cid"=>$rowoChecklist["checklist_id"]));                           
            $stmtPostpone = $conn->prepare("INSERT INTO booking(user_id, staff_id, booking_date, booking_note, booking_status, booking_type) 
                                            VALUES (:id, :staff, :date, :note, :status, :type)
                                          ");    
            $stmtPostpone->execute(array(":id"=>$id,":staff"=>$select, ":date"=>$date, ":note"=>$note, ":status"=>$status, ":type"=>$type));
            // ------ get old staff mail --------
            $stmtStaffMail = $conn->prepare("SELECT s.staff_email, b.booking_date, b.booking_note, u.user_name FROM booking b INNER JOIN staff s ON s.staff_id = b.staff_id INNER JOIN user u ON u.user_id = b.user_id WHERE b.booking_id = :obid LIMIT 1");
            $stmtStaffMail->bindParam(":obid", $obid);
            $stmtStaffMail->execute();
            $rowStaffMail = $stmtStaffMail->fetch(PDO::FETCH_ASSOC);
            $subject = "ผู้ใช้งานทำการยกเลิกการจองแล้ว || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
            $body = "
            <p>มีผู้ใช้งานได้ทำการยกเลิกการจองเข้ารับบริการ</p>
            <br>
                  <p>วันที่: ".$rowStaffMail["booking_date"]."</p>
                  <p>ผู้ใช้: ".$rowStaffMail["user_name"]."</p>
                  <p>รายละเอียด: ".$rowStaffMail["booking_note"]."</p>
                  <hr><br>
                  
            ";
            $mailer = new Mailer;
            $mailer->send($rowStaffMail["staff_email"], $subject, $body);
            // ------ delete old booking ------ //
            $stmtDeloBook = $conn->prepare("DELETE FROM booking WHERE booking_id = :obid");
            $stmtDeloBook = $conn->prepare("UPDATE booking SET booking_status = :bstatus WHERE booking_id = :obid");
            $stmtDeloBook->execute(array(":bstatus"=>$bstatus,":obid"=>$bid2));
            
            // ------ get new staff mail --------
            $stmtStaffMail2 = $conn->prepare("SELECT staff_email FROM staff WHERE staff_id = :staff LIMIT 1");
            $stmtStaffMail2->bindParam(":staff", $select);
            $stmtStaffMail2->execute();
            $rowStaffMail2 = $stmtStaffMail2->fetch(PDO::FETCH_ASSOC);
            $subject2 = "ผู้ใช้งานทำการจอง || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
            $body2 = "
            <p>มีผู้ใช้งานได้ทำการจองเข้าใช้งานบริการ</p>
            <br>
                  <p>วันที่: ".$date."</p>
                  <p>ผู้ใช้: ".$rowStaffMail["user_name"]."</p>
                  <p>รายละเอียด: ".$note."</p>
                  <hr><br>
                  
            ";
            $mailer = new Mailer;
            $mailer->send($rowStaffMail2["staff_email"], $subject2, $body2);
            unset($_POST["isPostpone"],$_POST["uid"],$_POST["select"],$_POST["book_date"],$_POST["book_note"],$id,$select,$date,$note);
          
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
					<h1>การนัดและการจอง</h1>
				</div>
				<?php if(isset($error)){foreach($error as $err){ echo $err; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="booking_table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>ประเภท</th>
                        <th>เจ้าหน้าที่</th>
                        <th>วันที่จอง</th>
                        <th>รายละเอียดการจอง</th>
                        <th>สถานะการจอง</th>
                        <th></th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT b.booking_id, u.user_name, s.staff_name, b.booking_date, b.booking_note, b.booking_status, b.booking_type
                                      FROM `booking` b
                                      INNER JOIN `staff` s ON s.staff_id = b.staff_id
                                      INNER JOIN `user` u ON u.user_id = b.user_id
                                      WHERE u.user_id = :uid AND b.booking_date >= :now;");
              $stmt->execute(array(":now"=>date('Y-m-d'), ":uid"=>$_SESSION["id"]));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $stmtCheck = $conn->prepare("SELECT check_status AS status FROM checklist WHERE booking_id = :bid");
                $stmtCheck->execute(array(":bid"=>$row["booking_id"]));
                $rowCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                echo '<tr>
                        <td>'. $row["booking_type"] .'</td>
                        <td>'. $row["staff_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["booking_status"] .'</td>
                        <td class="text-center">';
                          if($rowCheck["status"] != ""){
                            echo '<a class="text-success" title="ใช้บริการแล้ว"><i class="fa fa-check fa-fw"></i></a>';
                          }
                          else if($row["booking_status"] == 'รอการยืนยัน'){
                            echo '<a class="text-danger" href="#" data-toggle="modal" data-target="#del_appoint" data-bid="'. $row["booking_id"] .'" title="ยกเลิกการจอง"><i class="fa fa-close"></i></a>';
                          }else if($row["booking_status"] == "ยกเลิกแล้ว"){
                            echo '<a class="text-danger"><i class="fa fa-check fa-fw"></i></a>';
                          }else if($row["booking_type"] == "นัด"){
                            echo '<a class="text-info" data-toggle="modal" data-target="#postpone_appoint" data-bid2="'.$row["booking_id"].'" style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-fw"></i></a>';
                          }else if($row["booking_status"] == 'ยืนยันแล้ว'){
                            echo '<a class="text-success"><i class="fa fa-check"></i></a>';
                          }else if($row["booking_status"] == 'ยกเลิกการจอง') {
                            echo '<a class="text-danger"><i class="fa fa-close"></i></a>';
                          }else{
                            echo '<span>เกิดข้อผิดพลาด</span>';
                          }
                          echo '</td>
                      </tr>';
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

  <!-- DELETE modal -->
  <div class="modal fade" id="del_appoint" tabindex="-1" role="dialog" aria-labelledby="delAppoint">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="delAppoint">Delete Booking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="post" action="" name="delAppoint" id="delAppointForm">
            <p>คุณต้องการลบข้อมูลนี้ใช่หรือไม่</p>
            <input type="hidden" name="isDelAppoint" value="true">
            <input type="hidden" name="del" id="del_" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="delAppointForm" class="btn btn-danger">Delete Booking</button>
        </div>
      </div>
    </div>
  </div>

  <!-- postpone appointment -->
  <div class="modal fade" id="postpone_appoint" tabindex="-1" role="dialog" aria-labelledby="postponeAppoint">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="post">Postpone Appointment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="post" action="" name="postponeAppoint" id="postponeAppointForm">
						<div class="form-group text-center">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="radio" name="switch_book" value="st" onclick="getSelectBooking2(this.value)"> เลือกจากรายชื่อแพทย์
								</label>
							</div>
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="radio" name="switch_book" value="dt" onclick="getSelectBooking2(this.value)"> เลือกจากวันที่
								</label>
							</div>
							<div id="bookForm2"></div>
						</div>
            <input type="hidden" name="isPostpone" value="true">
            <input type="hidden" name="bid2" id="bookingid" value="">
            <input type="hidden" name="uid" value="<?php echo $_SESSION["id"]; ?>">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="postponeAppointForm" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
  
	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#booking_table').DataTable();
    });
    $('#del_appoint').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var res = button.data('bid')
      var modal = $(this)
      modal.find('#del_').val(res)
    });
    $('#postpone_appoint').on('show.bs.modal', function (event) {
      var button2 = $(event.relatedTarget)
      var res2 = button2.data('bid2')
      var modal2 = $(this)
      modal2.find('#bookingid').val(res2);
    })
	</script>
	<script>
  function getSelectBooking2(str){
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("bookForm2").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","/template/bookForm.php?q="+str,true);
    xmlhttp.send();
  }

  function getStImage2(val){
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("stImage").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","/template/stImage.php?q="+val,true);
    xmlhttp.send();
  }
  
  function getDtStaff2(date) {
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("dtStaff").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "/template/dtStaff.php?q="+date, true);
    xmlhttp.send();
  }
</script>
</body>
</html>
