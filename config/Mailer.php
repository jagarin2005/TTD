<?php 
  require '../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
  date_default_timezone_set('Asia/Bangkok');

  class Mailer {
    private $mail;
    private $username = "namnug.321@gmail.com";
    private $password = "qeadzcqe";
    private $fromName = "พระนครคลินิกการแพทย์แผนไทยประยุกต์";

    function __construct() {
      $this->mail = new PHPMailer;
    }

    public function send($to = "jagarin2005@gmail.com", $subject = "Test", $body = "Hello this is body content"){
      $this->setMail();
      $this->mail->Subject = $subject;
      $this->mail->Body = $body;
      $this->mail->AddAddress($to);

      if(!$this->mail->send()) {
        echo 'Mailer Error : '. $this->mail->ErrorInfo;
      } else {
        // echo 'mail is success';
      }
    }

    private function setMail(){
      $this->mail->CharSet = "utf-8";
      $this->mail->isSMTP();
      $this->mail->SMTPDebug = 0;
      // $this->mail->DebugOutput = 'html';
      $this->mail->Host = "smtp.gmail.com";
      $this->mail->Port = 465;
      $this->mail->SMTPAuth = true;
      $this->mail->SMTPSecure = 'ssl';
      $this->mail->IsHTML(true);
      $this->mail->Username = $this->username;
      $this->mail->Password = $this->password;
      $this->mail->SetFrom("ATTM@attm.com", $this->fromName);
      
    }
  }
?>