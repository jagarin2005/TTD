<?php 
if($user->is_loggedin()){
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isLogout"])){
      $user->logout();
      $user->redirect("/");
    }

    // booking function --------------------------------------
    if(isset($_POST["isBooking"])){
      $id = $_POST["uid"];
      $staff = trim($_POST["select"]);
      $date = trim($_POST["book_date"]);
      $note = trim($_POST["book_note"]);
      $status = "รอการยืนยัน";
      $type = "จอง";
      
      if($staff == "" || $staff == "..."){
        $error[] = "กรุณาเลือกการจอง";
      }else if($date == "") {
        $error[] = "กรุณาใส่วันที่";
      }else{
        try{
          $stmtBook = $conn->prepare("SELECT * FROM booking b INNER JOIN user u ON u.user_id = b.user_id WHERE b.user_id = :id AND b.booking_date = :book_date");
          $stmtBook->execute(array(":id"=>$id,":book_date"=>$date));
          $rowBook=$stmtBook->fetch(PDO::FETCH_ASSOC);

          if($rowBook['user_id'] == $id && $rowBook['booking_date'] == $date) {
            $error[] = "คุณได้ทำการจองในวันนี้ไว้แล้ว";
          }
          else {
            $stmtInsBook = $conn->prepare("INSERT INTO booking(user_id, staff_id, booking_date, booking_note, booking_status, booking_type) 
                                    VALUES (:user,:staff,:date,:note,:status,:type)");
            $stmtInsBook->execute(array(":user"=>$id, ":staff"=>$staff, ":date"=>$date, ":note"=>$note, ":status"=>$status, ":type"=>$type));
            $stmtUser = $conn->prepare("SELECT user_name FROM user WHERE user_id = :id");
            $stmtUser->bindParam(":id", $id);
            $stmtUser->execute();
            $rowUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
            $stmtStaffMail = $conn->prepare("SELECT staff_email FROM staff WHERE staff_id = :staff LIMIT 1");
            $stmtStaffMail->bindParam(":staff", $staff);
            $stmtStaffMail->execute();
            $rowStaffMail = $stmtStaffMail->fetch(PDO::FETCH_ASSOC);
            $subject = "ผู้ใช้งานทำการจอง || พระนครคลินิกการแพทย์แผนไทยประยุกต์";
            $body = "
            <p>มีผู้ใช้งานได้ทำการจองเข้าใช้งานบริการ</p>
            <br>
                  <p>วันที่: ".$date."</p>
                  <p>ผู้ใช้: ".$rowUser["user_name"]."</p>
                  <p>รายละเอียด: ".$note."</p>
                  <hr><br>
                  
            ";
            $mailer = new Mailer;
            $mailer->send($rowStaffMail["staff_email"], $subject, $body);
            unset($_POST["isBooking"],$mailer,$id,$staff,$date,$note,$status);
          }
        }catch(PDOException $e){
          echo $e->getMessage();
        }
      }
    }
    // -----------------------------------------------------

  }
}
?> 