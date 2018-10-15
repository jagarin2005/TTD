<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
  if(!$user->is_admin()){
    $user->redirect("/");
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
					<h1>คะแนน</h1>
				</div>
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php 
              echo '
                  <table id="booking_table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>คะแนน</th>
                        <th>เจ้าหน้าที่</th>
                        <th>จำนวนผู้ให้คะแนน</th>
                      </tr></thead><tbody>';
              $stmt = $conn->prepare("SELECT sc.*, staff_name 
                                      FROM score sc
                                      INNER JOIN staff s ON s.staff_id = sc.staff_id
                                      ORDER BY score_score ASC
                                      ");
              $stmt->execute();
              while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>'. $row["score_score"] .'</td>
                        <td>'. $row["staff_name"] .'</td>
                        <td>'. $row["score_count"] .'</td>
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
      $('#booking_table').DataTable({
        "order": [0, 'desc']
      });
    });
  </script>
</body>
</html>
