<?php
include_once("../../config/conn.php"); 
include_once("../../config/Mailer.php"); 
  if(isset($_POST["mailer"])){
    $mail = new Mailer;
    $mail->send();
    $user->redirect("/p/dashboard");
    exit();
  }
?>