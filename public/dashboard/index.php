<?php include_once("../../config/conn.php"); ?>
<?php 
	if(!$user->is_loggedin()) {
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
			
			<main class="col-md-9 float-left col px-5 pl-md-2 pt-2 main">
				<a href="#" data-target="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-2x py-2 p-1"></i></a>
				<div class="page-header">
					<h1>ยินดีต้อนรับ</h1>
				</div>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-6 mx-auto">
						<?php 
							$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :id");
							$stmt->bindParam(":id", $_SESSION["id"]);
							$stmt->execute();
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="card">
							<h4 class="card-header">ข้อมูลส่วนตัว</h4>
							<div class="card-body">
								<form>
									<div class="form-group row">
										<label for="staticName" class="col-sm-4 col-lg-3 col- col-form-label">Name</label>
										<div class="col-sm-8 col-lg-9">
											<input type="text" readonly class="form-control-plaintext" id="staticName" value="<?php echo $row["user_name"]; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-lg-3 col-form-label">Email</label>
										<div class="col-sm-8 col-lg-9">
											<input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $row["user_email"]; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticTel" class="col-sm-4 col-lg-3 col-form-label">Tel.</label>
										<div class="col-sm-8 col-lg-9">
											<input type="text" readonly class="form-control-plaintext" id="staticTel" value="<?php echo $row["user_tel"]; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticSex" class="col-sm-4 col-lg-3 col-form-label">Sex</label>
										<div class="col-sm-8 col-lg-9">
											<input type="text" readonly class="form-control-plaintext" id="staticSex" value="<?php echo $row["user_sex"]; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticRole" class="col-sm-4 col-lg-3 col-form-label">Role</label>
										<div class="col-sm-8 col-lg-9">
											<input type="text" readonly class="form-control-plaintext" id="staticRole" value="<?php echo $row["user_role"]; ?>">
										</div>
									</div>
									<!-- <button type="submit" class="btn btn-primary" name="mailer" value="true">test mailer</button> -->
								</form>
							</div>
						</div>
					</div>
				</div>
			</main>
			<footer class="col-md-9 clearfix my-5 p-3"></footer>
		</div>
	</div>
	
  <?php include_once("../template/footer.js.php"); ?>
</body>
</html>
