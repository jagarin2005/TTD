<?php include_once("../../config/conn.php"); ?>
<?php 

?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/p/");
	}
  if(!$user->is_staff()){
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
			
			<main class="col-12 col-sm-12 col-md-9 col-lg-10 float-left px-5 pl-md-2 pt-2 main">
				<a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
				<div class="page-header">
					<h1>วันที่เข้าปฏิบัติงาน</h1>
				</div>
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
                        <th>วันที่</th>
                        <th>หน้าที่</th>
                      </tr></thead><tbody>';
              $id = $_SESSION["id"];
              $stmt = $conn->prepare("SELECT shifts.s_date, shifts.s_position FROM shifts INNER JOIN staff ON shifts.staff_id = staff.staff_id WHERE staff.user_id = :id");
              $stmt->execute(array(":id"=>$id));
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
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

	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#shifts_table').DataTable();
    });
  </script>
</body>
</html>
<?php $conn = null ?>
