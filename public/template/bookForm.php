<?php include_once("../../config/conn.php"); ?>
<?php 
  $q = $_GET["q"];
  $stmt = $conn->prepare("SELECT * FROM staff");
  $stmt->execute();
  
  if($q == 'st'){
    echo '
    <div class="px-5 py-1">
    <select class="form-control" name="stSelect" onchange="getStImage(this.value)" required>
      <option selected>...</option>';
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.$row["staff_id"].'">'.$row["staff_name"].'</option>';
      }
    echo 
    '</select></div>';
    echo '<div id="stImage"></div>';
  }
?>

