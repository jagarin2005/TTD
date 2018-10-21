<?php include_once("../../config/conn.php"); ?>
<?php 
  if(!$user->is_loggedin()) {
		$user->redirect("/");
	}
	if(!$user->is_user()){
    $user->redirect("/dashboard");
  }
  require_once("../template/navbarFunction.php");
  if(isset($_POST["isRating"])) {
    $score = $_POST["rating"];
    $note = $_POST["rating_note"];
    $bid = $_POST["bid"];
    $cid = $_POST["cid"];
    $active = 1;
    if($score == ""){
      $score=0;
    }
    try{

      $stmtInsScore = $conn->prepare("UPDATE scorelog SET sl_score = :score, sl_note = :note, sl_active = :active WHERE booking_id = :bid AND checklist_id = :cid");
      $stmtInsScore->execute(array(":score"=>$score, ":note"=>$note, ":active"=>$active, ":bid"=>$bid, ":cid"=>$cid));
      $stmtCheckScore = $conn->prepare("SELECT staff_id FROM scorelog WHERE booking_id = :bid AND checklist_id = :cid");
      $stmtCheckScore->execute(array(":bid"=>$bid, ":cid"=>$cid));
      $rowCheckScore = $stmtCheckScore->fetch(PDO::FETCH_ASSOC);
      $stmtCheckScore2 = $conn->prepare("SELECT COUNT(sl_id) AS count_score, AVG(sl_score) AS avg_score FROM scorelog WHERE staff_id = :staff");
      $stmtCheckScore2->execute(array(":staff"=>$rowCheckScore["staff_id"]));
      $rowCheckScore2 = $stmtCheckScore2->fetch(PDO::FETCH_ASSOC);

      $staff = $rowCheckScore["staff_id"];
      $count = $rowCheckScore2["count_score"];
      $res = $rowCheckScore2["avg_score"];
      $stmtResScore = $conn->prepare("UPDATE score SET score_count = :count, score_score = :score WHERE staff_id = :staff");
      $stmtResScore->execute(array(":count"=>$count, ":score"=>$res, ":staff"=>$staff));
    }catch(PDOException $e) {
      echo $e->getMessage();
    }
    unset($_POST["isRating"]);
    
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
					<h1>ให้คะแนน</h1>
				</div>
				<?php if(isset($error)){while($error){ echo $error; }} ?>
				<p class="lead"></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
            <table id="booking_table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>วันที่</th>
                  <th>เจ้าหน้าที่</th>
                  <th>ให้คะแนน</th>
                </tr></thead><tbody>
              <?php
                $stmt = $conn->prepare("SELECT b.booking_date, s.staff_name, sl.*
                                        FROM scorelog sl
                                        INNER JOIN staff s ON s.staff_id = sl.staff_id
                                        INNER JOIN user u ON u.user_id = sl.user_id
                                        INNER JOIN booking b ON b.booking_id = sl.booking_id
                                        INNER JOIN checklist c ON c.checklist_id = sl.checklist_id
                                        WHERE u.user_id = :id
                                        ORDER BY b.booking_date ASC
                                      ");
                $stmt->execute(array(":id"=>$_SESSION["id"]));
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo '<tr>
                          <td>'.$row["booking_date"].'</td>
                          <td>'.$row["staff_name"].'</td>
                          <td class="text-center">';
                          if($row["sl_active"] == 0){ echo '<a class="badge badge-warning text-white" data-toggle="modal" data-target="#rating_modal" data-bid="'.$row["booking_id"].'" data-cid="'.$row["checklist_id"].'" style="cursor: pointer;"><i class="fa fa-star-o fa-fw"></i> ให้คะแนน</a>';}
                          if($row["sl_active"] == 1){ echo '<a class="badge badge-success text-white"><i class="fa fa-check fa-fw"></i> ให้คะแนนแล้ว</a>';}
                          echo '</td>
                        </tr>';
                }
                ?>
                </tbody>
              </table>
          </div>
          <div class="col-md-12">

          </div>
				</div>
			</main>
		</div>
  </div>

  <!-- rating modal -->
  <div class="modal fade" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="rating">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body mx-auto">
          <form method="post" action="" name="rating" id="ratingForm">
            <div class="col-12">
              <div class="text-justify">
                <h5>โปรดให้คะแนนความพึงพอใจ</h5>
              </div>
              <div class="star-rating text-center">
                <fieldset>
                  <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Outstanding">5 stars</label>
                  <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Very Good">4 stars</label>
                  <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Good">3 stars</label>
                  <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Poor">2 stars</label>
                  <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Very Poor">1 star</label>
                </fieldset>
              </div>
              <div><p class="text-center lead" id="rating_text"></p></div>
              <textarea class="form-control" name="rating_note" id="rating_note" cols="" rows="5" placeholder="คำแนะนำหรือติชม..."></textarea>
            </div>
            <input type="hidden" name="bid" id="bid" value="">
            <input type="hidden" name="cid" id="cid" value="">
            <input type="hidden" name="isRating" value="true">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="ratingForm" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
  
	<?php include_once("../template/footer.js.php"); ?>
	<script>
    $(document).ready(function() {
      $('#booking_table').DataTable();
    });
    $('#rating_modal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var bid = button.data('bid')
      var cid = button.data('cid')
      var modal = $(this)
      modal.find('#bid').val(bid)
      modal.find('#cid').val(cid)
    })
    function ratingHold(e,q) {
      $(e).click(function() {
        $('#rating_text').text(q)
      })
    }
    ratingHold("#star5","ยอดเยี่ยม");
    ratingHold("#star4","ดีมาก");
    ratingHold("#star3","ปานกลาง");
    ratingHold("#star2","พอใช้");
    ratingHold("#star1","ต้องปรับปรุง");
  </script>
</body>
</html>
