<?php include_once("../../config/conn.php"); ?>
<?php 
  $q = $_GET["q"];
  $stmt = $conn->prepare("SELECT * FROM shifts sh, staff s WHERE s.staff_id = sh.staff_id AND sh.s_date = :date");
  $stmt->execute(array(":date"=>$q));
  echo '<div class="px-5 py-1"><select class="form-control" name="select" required><option selected>...</option>';
  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    echo '<option value="'.$row["staff_id"].'">'.$row["staff_name"].'</option>';
  }
  echo '</select></div>';
  echo '<div class="px-5 py-1">
  <textarea name="book_note" class="form-control" rows="3" cols="" placeholder="อธิบายอาการ..."></textarea>
</div>';
?>


