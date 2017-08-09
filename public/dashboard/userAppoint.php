<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
	if($user->is_staff()){
    $user->redirect("/p/dashboard");
    exit();
  }
  if($_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["isDelAppoint"])){
      try{
        $id = $_POST["del"];
        $stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = :id");
        $stmt->execute(array(":id"=>$id));
      }catch(PDOException $e){
          echo $e->getMessage();
      }
      unset($id);
      unset($_POST["isDelAppoint"]);
      $user->redirect("/p/userAppoint");
      exit();
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
                        <th>ประเภท</th>
                        <th>เจ้าหน้าที่</th>
                        <th>วันที่จอง</th>
                        <th>รายละเอียดการจอง</th>
                        <th>สถานะการจอง</th>
                        <th></th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT b.booking_id, u.user_name, s.staff_name, b.booking_date, b.booking_note, b.booking_status, b.booking_type
                                      FROM `booking` b, `staff` s, `user` u
                                      WHERE u.user_id = b.user_id AND s.staff_id = b.staff_id AND u.user_id = :uid AND b.booking_date >= :now;");
              $stmt->execute(array(":now"=>date('Y-m-d'), ":uid"=>$_SESSION["id"]));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["booking_type"] .'</td>
                        <td>'. $row["staff_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["booking_status"] .'</td>
                        <td class="text-center">';
                          if($row["booking_status"] == 'รอการยืนยัน'){
                            echo '<a class="text-danger" href="#" data-toggle="modal" data-target="#del_appoint" data-bid="'. $row["booking_id"] .'" title="ยกเลิกการจอง"><i class="fa fa-close"></i></a>';
                          }else if($row["booking_status"] == 'ยืนยันแล้ว'){
                            echo '<a class="text-muted" title="ยกเลิกการจอง"><i class="fa fa-close"></i></a>';
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
          <h5 class="modal-title" id="delShifts">Delete Booking</h5>
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
          <button type="submit" form="delAppointForm" class="btn btn-primary">Delete Booking</button>
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
    $('#del_appoint').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var res = button.data('bid')
      var modal = $(this)
      modal.find('#del_').val(res)
    })
  </script>
</body>
</html>
