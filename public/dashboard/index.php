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
					<h1>ยินดีต้อนรับ</h1>
				</div>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						
					</div>
				</div>
			</main>
		</div>
	</div>
  <?php include_once("../template/footer.js.php"); ?>
</body>
</html>
