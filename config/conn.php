<?php 

session_start();

$server = "";
$db = "ttd";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connection successfully";
} catch(PDOException $e) {
  // echo "Connection failed : ". $e->getMessage();
}
include_once("User.php");
$user = new User($conn);

// ลบกะวันที่ผ่านมาแล้ว 1 สัปดาห์
// $adShifts = $conn->prepare("DELETE FROM shifts WHERE s_date < :ago");
// $adShifts->execute(array(":ago"=>date('Y-m-d', strtotime('-1 week'))));



?>