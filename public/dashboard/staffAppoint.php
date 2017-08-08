<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
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
					<h1>การจัดการกะเข้าทำงาน</h1>
				</div>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#add_shifts"><i class="fa fa-plus"> Add</i></button>
        <!-- <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#calendar"><i class=""></i></button> -->
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="shifts_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>เจ้าหน้าที่</th>
                        <th>วันที่</th>
                        <th>หน้าที่</th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT staff.staff_name, shifts.s_date, shifts.s_position FROM shifts INNER JOIN staff ON shifts.staff_id = staff.staff_id");
              $stmt->execute();
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["staff_name"] .'</td>
                        <td>'. $row["s_date"] .'</td>
                        <td>'. $row["s_position"] .'</td>
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
  
  <!-- Modal add shifts -->
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

  <!-- modal calendar NOT WORK -->
  <div class="modal fade" id="calendar" tabindex="-1" role="dialog" aria-labelledby="calendar">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="calendar">Add Shifts</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <?php
            
          ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">OK</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
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
