<?php
  class User {
    private $db;

    function __construct($db_con) {
      $this->db = $db_con;
    }

    public function register($email,$name,$password,$role,$tel,$sex) {
      try {
        if($role == 'user'){
          $enc_password = md5($password);
          $hash = md5( rand(0,165728) );
          $stmt = $this->db->prepare("INSERT INTO user (user_name, user_email, user_pwd, user_role, user_tel, user_sex, user_hash) VALUES (:name, :email, :password, :role, :tel, :sex, :hash)");
          $stmt->bindParam(":name", $name);
          $stmt->bindParam(":email", $email);
          $stmt->bindParam(":password", $enc_password);
          $stmt->bindParam(":role", $role);
          $stmt->bindParam(":tel", $tel);
          $stmt->bindParam(":sex", $sex);
          $stmt->bindParam(":hash", $hash);
          $stmt->execute();
          // $this->send_email($email, $hash); uncomment for confirm email *1
          return $stmt;
        }else if($role == 'staff') {
          $enc_password = md5($password);
          $stmt = $this->db->prepare("INSERT INTO user (user_name, user_email, user_pwd, user_role, user_tel, user_sex) VALUES (:name, :email, :password, :role, :tel, :sex)");
          $stmt->bindParam(":name", $name);
          $stmt->bindParam(":email", $email);
          $stmt->bindParam(":password", $enc_password);
          $stmt->bindParam(":role", $role);
          $stmt->bindParam(":tel", $tel);
          $stmt->bindParam(":sex", $sex);
          $stmt->execute();

          $stmt3 = $this->db->prepare("SELECT user_id FROM user WHERE user_email LIKE :email");
          $stmt3->execute(array(":email"=>$email)); 
          if($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
            $uid = $row["user_id"];
            $stmt2 = $this->db->prepare("INSERT INTO staff (staff_name, staff_email, staff_tel, user_id) VALUES (:name, :email, :tel, :uid)");
            $stmt2->bindParam(":name",$name);
            $stmt2->bindParam(":email",$email);
            $stmt2->bindParam(":tel",$tel);
            $stmt2->bindParam(":uid",$uid);
            $stmt2->execute();
            $stmtStaff = $this->db->prepare("SELECT * FROM staff WHERE staff_email LIKE :semail");
            $stmtStaff->bindParam(":semail", $email);
            $stmtStaff->execute();
            $rowStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC);
            $stmtInsScore = $this->db->prepare("INSERT INTO score VALUES (:staff, 0, 0)");
            $stmtInsScore->bindParam(":staff", $rowStaff["staff_id"]);
            $stmtInsScore->execute();
          }
          
        }
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
    }

    public function update($id, $email, $name, $role, $tel, $sex){
      try{
        $stmt = $this->db->prepare("UPDATE user SET user_email = :email, user_name = :name, user_role = :role, user_tel = :tel, user_sex = :sex WHERE user_id = :id");
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":role",$role);
        $stmt->bindParam(":tel",$tel);
        $stmt->bindParam(":sex",$sex);
        $stmt->bindParam(":id",$id);
        $stmt->execute();

        $stmt2 = $this->db->prepare("SELECT * FROM user u,staff s WHERE u.user_id = s.user_id AND s.user_id = :id");
        $stmt2->execute(array(":id"=>$id));
        if($row=$stmt2->fetch(PDO::FETCH_ASSOC)){
          $stmt3 = $this->db->prepare("UPDATE staff SET staff_email = :email, staff_name = :name, staff_tel = :tel, staff_sex = :sex WHERE user_id = :id");
          $stmt3->bindParam(":email",$email);
          $stmt3->bindParam(":name",$name);
          $stmt3->bindParam(":tel",$tel);
          $stmt3->bindParam(":sex",$sex);
          $stmt3->bindParam(":id",$id);
          $stmt3->execute();
        }

        return $stmt;
      }catch(PDOEception $e){
        echo $e->getMessage();
      }
    }

    public function delete($id){
      try{
        $stmt2 = $this->db->prepare("DELETE FROM user WHERE user_id = :id");
        $stmt2->execute(array(":id"=>$id));
        $stmt3 = $this->db->prepare("DELETE FROM staff WHERE user_id = :id");
        $stmt3->execute(array(":id"=>$id));
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }

    public function send_email($email, $hash) {
      $to = $email;
      $subject = 'ยืนยันการสมัครสมาชิก || คลินิกแพทย์แผนไทยประยุกต์';
      $message = '
      ขอบคุณที่สมัครเป็นสมาชิกกับทางเรา
      กรณาคลิกที่ลิงก์เพื่อยืนยันอีเมล์นี้

      E-mail: '.$email.'
      Link: http://localhost:8000/p/verify?email='.$email.'&confirm_code='.$hash.'

      ขอบคุณค่ะ
      ________________________________________________
      '; // edit link 3*

      $headers = 'From:jakarin.ij66@pnru.ac.th'."\r\n";
      mail($to, $subject, $message, $headers);
    }

    public function confirm_email($email, $confirm_code) {
      try{
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_email=:email AND user_hash=:confirm_code");
        $stmt->execute(array(':email'=>$email, ':confirm_code'=>$confirm_code));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0) {
          if($email == $_GET["email"] && $confirm_code == $_GET["confirm_code"]) {
            
            return true;
          }
          else{
            return false;
          }
        }
      }catch(PDOException $e) {
       echo ''; 
      }
    }

    public function setActivate($email, $hash) {
      $stmt = $this->db->prepare("UPDATE user SET user_active = 1 WHERE user_email = :email AND user_hash = :hash");
      $stmt->execute(array(':email'=>$email, ':hash'=>$hash));
      return true;
    }

    public function login($email, $password) {
      try {
        $enc_pass = md5($password);
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_email=:email AND user_pwd=:password"); // add " AND user_active=1" to confirm email *2
        $stmt->execute(array(':email'=>$email, ':password'=>$enc_pass));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0) {
          if($userRow['user_pwd'] == $enc_pass) {
            $_SESSION['id'] = $userRow['user_id'];
            $_SESSION['email'] = $userRow['user_email'];
            $_SESSION['name'] = $userRow['user_name'];
            $_SESSION['role'] = $userRow['user_role'];
            if($userRow["user_role"] == "staff"){
              $stmtRoleStaff = $this->db->prepare("SELECT staff_id FROM staff WHERE user_id = :id");
              $stmtRoleStaff->execute(array(":id"=>$userRow["user_id"]));
              $rowRoleStaff = $stmtRoleStaff->fetch(PDO::FETCH_ASSOC);
              $_SESSION["staff"] = $rowRoleStaff["staff_id"];
            }
            return true;
          }
          else{
            return false;
          }
        }
      }catch(PDOException $e) {
        echo $e->getMessage();
      }
    }

    public function is_loggedin() {
      if(isset($_SESSION["id"])) {
        return true;
      }
    }

    public function is_admin() {
      if(isset($_SESSION["id"]) && $_SESSION["role"] == "admin") {
        return true;
      }
    }

    public function is_staff() {
      if(isset($_SESSION["id"]) && $_SESSION["role"] == "staff") {
        return true;
      }
    }

    public function is_user() {
      if(isset($_SESSION["id"]) && $_SESSION["role"] == "user") {
        return true;
      }
    }

    public function is_activate() {
      
    }

    public function redirect($url) {
      header("Location: $url");
    }

    public function logout() {
      session_destroy();
      unset($_SESSION["id"]);
      unset($_SESSION["email"]);
      unset($_SESSION["name"]);
      unset($_SESSION["role"]);
      return true;
    }
  }
?>