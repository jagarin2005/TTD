<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
	if($user->is_user()){
    $user->redirect("/p/dashboard");
    exit();
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
					<h1>บันทึกการรักษา</h1>
				</div>
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="booking_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>ผู้ใช้</th>
                        <th>จองวันที่</th>
                        <th>อาการ</th>
                        <th>การรักษา</th>
                        <th>ผลการรักษา</th>
                        <th></th>
                      </tr></thead><tbody>';
                      $id = $_SESSION["id"];
              $stmt = $conn->prepare("SELECT b.booking_date, b.booking_note, b.booking_status,b.booking_type,c.check_status, c.checklist_note, u.user_name, c.checklist_id 
                                      FROM checklist c
                                      INNER JOIN booking b ON b.booking_id = c.booking_id
                                      INNER JOIN staff s ON s.staff_id = c.staff_id
                                      INNER JOIN user u ON u.user_id = c.user_id
                                      WHERE s.user_id = :id");
                                      
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["checklist_note"] .'</td>
                        <td>'. $row["check_status"] .'</td>
                        <td class="text-center">';
                          if($row["check_status"] == ''){echo '<a class="text-info" href="/p/staffEditCheck?q='.$row["checklist_id"].'"><i class="fa fa-pencil fa-fw"></i>';}
                          if($row["check_status"] == 'นัดหมายการรักษาครั้งต่อไป'){echo '<a class="text-primary" href="#"><i class="fa fa-asterisk fa-fw" data-toggle="tooltip" data-placement="right" title="นัดหมายครั้งต่อไป"></i>';}
                          if($row["check_status"] == 'การรักษาเสร็จสิ้น'){echo '<a class="text-success" href="#" title="นัดหมายครั้งต่อไป"><i class="fa fa-check fa-fw"></i>';}
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

  
  <div class="modal fade" id="add_shifts" tabindex="-1" role="dialog" aria-labelledby="shifts">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shifts">Add Shifts</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="post" action="" name="addshifts" id="addShiftsForm">
            <div class="form-group row" id="u_type">
              <div class="col-12">
                <select class="form-control form-control-lg" name="s_staff">
									<?php 
										$stmt = $conn->prepare("SELECT * FROM staff");
										$stmt->execute();
										echo "<option selected>เลือกเจ้าหน้าที่</option>";
										while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
											echo "<option value='".$row["staff_id"]."'>".$row["staff_name"]."</option>";
										}	
									?>
                  
                </select>
              </div>
            </div>
            <div class="form-group row" id="u_name">
              <div class="col-12">
                <input type="date" class="form-control form-control-lg" name="s_date" placeholder="วันที่">
              </div>
            </div>
            <div class="text-center">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="s_position" id="sex" value="ว/น" required> ว/น <i class=""></i>
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="s_position" id="sex" value="น/ว" required> น/ว <i class=""></i>
                </label>
              </div>
							<div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="s_position" id="sex" value="น.2" required> น.2 <i class=""></i>
                </label>
              </div>
            </div>
            <input type="hidden" name="isAddShifts" value="true">
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="addShiftsForm" class="btn btn-primary">Add Shifts</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#booking_table').DataTable();
    });
  </script>
</body>
</html>
