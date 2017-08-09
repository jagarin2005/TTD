<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
	if($user->is_user()){
    $user->redirect("/p/dashboard");
    exit();
  }

  $notify = $conn->prepare("SELECT check_status FROM checklist");
  $notify->execute();
  if($res = $notify->fetch(PDO::FETCH_ASSOC)) {
  
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
                        <th>ผลการรักษา</th>
                        <th>รายละเอียด</th>
                        <th></th>
                      </tr></thead><tbody>';
                      $id = $_SESSION["id"];
              $stmt = $conn->prepare("SELECT b.booking_date, b.booking_note, b.booking_status,b.booking_type,c.check_status, c.checklist_note, u.user_name, c.checklist_id 
                                      FROM checklist c, booking b, staff s, user u
                                      WHERE s.staff_id = c.staff_id AND b.booking_id = c.booking_id AND s.user_id = :id AND u.user_id = c.user_id");
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["booking_note"] .'</td>
                        <td>'. $row["check_status"] .'</td>
                        <td>'. $row["checklist_note"] .'</td>
                        <td>';
                          if($row["check_status"] == ''){echo '<a class="" href="/p/staffEditCheck?q='.$row["checklist_id"].'"><i class="fa fa-pencil fa-fw"></i>';}
                          if($row["check_status"] == 'นัดหมายการรักษาครั้งต่อไป'){echo '<a class="" href="#" title="นัดหมายครั้งต่อไป"><i class="fa fa-asterisk fa-fw"></i>';}
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
  
	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#booking_table').DataTable();
    });
  </script>
</body>
</html>
