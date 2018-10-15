<?php 

session_start();
date_default_timezone_set('Asia/Bangkok');

$server = "db";
$port = "3306";
$db = "ttd";
$username = "root";
$password = "12345678";

try {
  $conn = new PDO("mysql:host=$server;port=$port;dbname=$db", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connection successfully";
} catch(PDOException $e) {
  // echo "Connection failed : ". $e->getMessage();
}

require_once 'Mailer.php';
require_once 'User.php';
$user = new User($conn);

?>