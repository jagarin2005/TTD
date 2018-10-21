<?php include_once("../../config/conn.php"); ?>
<?php 

?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
  if(!$user->is_staff()){
    $user->redirect("/");
  }
?>
<?php
  require_once("../template/navbarFunction.php");
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
					<h1>ดูคะแนน</h1>
				</div>
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
        <hr>
				<div class="row">
          <?php  
            $stmtScore = $conn->prepare("SELECT * FROM score WHERE staff_id = :staff");
            $stmtScore->execute(array(":staff"=>$_SESSION["staff"]));
            $rowScore = $stmtScore->fetch(PDO::FETCH_ASSOC);
          ?>
          <div class="col-md-12"><p>คะแนนเฉลี่ย : <?php echo $rowScore["score_score"]; ?></p></div>
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="shifts_table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>วันที่</th>
                        <th>ผู้ใช้</th>
                        <th>คำติชม</th>
                        <th>คะแนน</th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT sl.*, booking_date, user_name 
                                      FROM scorelog sl
                                      INNER JOIN user u ON u.user_id = sl.user_id
                                      INNER JOIN booking b ON b.booking_id = sl.booking_id 
                                      WHERE sl.staff_id = :staff
                                    ");
              $stmt->execute(array(":staff"=>$_SESSION["staff"]));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["booking_date"] .'</td>
                        <td>'. $row["user_name"] .'</td>
                        <td>'. $row["sl_note"] .'</td>
                        <td>'. $row["sl_score"] .'</td>
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
