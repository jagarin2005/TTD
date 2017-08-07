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
				<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#add_shifts"><i class="fa fa-plus"> Add</i></button>
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
                        <th>เจ้าหน้าที่</th>
                        <th>วันที่จอง</th>
                        <th>รายละเอียดการจอง</th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT a.user_name AS user1, b.user_name AS user2 FROM user a, user b WHERE a.user_role LIKE 'user' AND b.user_role LIKE 'staff'");
              $stmt->execute();
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["user_id"] .'</td>
                        <td>'. $row["user_email"] .'</td>
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
  
  <!-- modal -->
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
										$stmt = $conn->prepare("SELECT * FROM user WHERE user_role LIKE 'staff'");
										$stmt->execute();
										echo "<option selected>เลือกเจ้าหน้าที่</option>";
										while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
											echo "<option value='".$row["user_id"]."'>".$row["user_name"]."</option>";
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
                  <input class="form-check-input" type="checkbox" name="s_position" id="sex" value="ว" checked> ว/น <i class=""></i>
                </label>
              </div>
							<div class="form-check form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="s_position" id="sex" value="น.2"> น.2 <i class=""></i>
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
