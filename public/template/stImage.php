<?php include_once("../../config/conn.php"); ?>
<?php 
  $q = $_GET["q"];
  $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id = :id");
  $stmt->execute(array(":id"=>$q));
  
  if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    echo '<img class="img-thumbnail" width="150" height="280" src="'.$row["staff_image"].'" alt="'.$row["staff_name"].'"></img>';
  }
  $stmt2 = $conn->prepare("SELECT staff.staff_id, shifts.s_date FROM shifts, staff WHERE staff.staff_id = shifts.staff_id AND shifts.staff_id = :id");
  $stmt2->execute(array(":id"=>$q));
  echo '<div class="px-5 py-1"><select class="form-control" name="book_date" required><option selected>...</option>';
  while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
    echo '<option value="'.$row2["s_date"].'">'.$row2["s_date"].'</option>';
  }
  echo '</select></div>';
  echo '<div class="px-5 py-1">
  <textarea name="book_note" class="form-control" rows="3" cols="" placeholder="อธิบายอาการ..."> </textarea>
</div>';
?>


