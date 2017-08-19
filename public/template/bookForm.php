<?php include_once("../../config/conn.php"); ?>
<?php 
  $q = $_GET["q"];
  $stmt = $conn->prepare("SELECT * FROM staff");
  $stmt->execute();
  
  if($q == 'st'){
    echo '
    <div class="px-5 py-1">
    <select class="form-control" name="select" onchange="getStImage(this.value)" required>
      <option selected>...</option>';
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.$row["staff_id"].'">' . $row["staff_name"] . '</option>';
      }
    echo 
    '</select></div>';
    echo '<div id="stImage"></div>';
  }
 
  if($q == 'dt'){
    echo '
    <div class="px-5 py-1">
      <input type="date" class="form-control" name="book_date" min="'.date("Y-m-d", strtotime("+1 day")).'" onchange="getDtStaff(this.value)">
    </div>';
    echo '<div id="dtStaff"></div>';
  }
  
?>

