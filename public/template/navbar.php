<!-- Navbar -->
<?php 
if($user->is_loggedin()){
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["isLogout"])){
      $user->logout();
      $user->redirect("/p/");
    }
    if(isset($_POST["isBooking"])){
      $id = $_POST["uid"];
      $select = trim($_POST["select"]);
      $date = trim($_POST["book_date"]);
      $note = trim($_POST["book_note"]);
      $status = "รอการยืนยัน";
      $type = "จอง";
      
      if($select == "" || $select == "..."){
        $error[] = "กรุณาเลือกการจอง";
      }else if($date == "") {
        $error[] = "กรุณาใส่วันที่";
      }else{
        try{
          $stmt = $conn->prepare("SELECT * FROM booking b WHERE b.user_id = :id AND b.booking_date = :book_date");
          $stmt->execute(array(":id"=>$id,":book_date"=>$date));
          $row=$stmt->fetch(PDO::FETCH_ASSOC);

          if($row['user_id'] == $id && $row['booking_date'] == $date) {
            $error[] = "คุณได้ทำการจองในวันนี้ไว้แล้ว";
          }
          else {
            $stmt = $conn->prepare("INSERT INTO booking(user_id, staff_id, booking_date, booking_note, booking_status, booking_type) 
                                    VALUES (:user,:staff,:date,:note,:status,:type)");
            $stmt->execute(array(":user"=>$id, ":staff"=>$select, ":date"=>$date, ":note"=>$note, ":status"=>$status, ":type"=>$type));
            $id = null;
            $select = null;
            $date = null;
            $note = null;
            $status = null;
            unset($_POST["isBooking"]);
            $user->redirect("/p/");
            exit();
          }
        }catch(PDOException $e){
          echo $e->getMessage();
        }
      }
    }
  }
}

?> 
<nav class="navbar navbar-expand-lg bg-faded navbar-light fixed-top" role="navbar">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars fa-fw"></i>
  </button>
  <a class="navbar-brand d-lg-none">Menu</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="/p/" id="index_nav">หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#product" id="product_nav">สินค้า</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#activity" id="activity_nav">กิจกรรม</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#contact" id="contact_nav">ติดต่อเรา</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/#about" id="about_nav">เกี่ยวกับคลินิกฯ</a>
      </li>
    </ul>
    <hr class="col-12 d-lg-none" style="width: 90%;">
    <ul class="navbar-nav mt-2 mt-lg-0">
    <?php 

    if($user->is_loggedin()) {
      if($user->is_user() || $user->is_staff()) {
        echo '<li class="nav-item dropdown px-1">
                <a class="nav-link" id="noti_bell" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                  <div style="position: relative;">
                    <i class="fa fa-bell fa-fw" aria-hidden="true">
                      <span class="badge badge-pill badge-danger" style="position: absolute;left: 10px;bottom: 10px;">
                        1
                      </span>
                      <span class="sr-only">unread messages</span>
                    </i>
                    <span class="d-lg-none d-inline"> การแจ้งเตือน</span>
                  </div>
                </a>
                <div class="dropdown-menu" aria-lebelledby="noti_bell">
                  <a class="dropdown-item">Item 1</a>
                  <a class="dropdown-item">Item 2</a>
                  <a class="dropdown-item">Item 3</a>
                </div>
              </li>
              ';       
      }
      echo '
      <li class="nav-item dropdown px-1 d-lg-inline-block d-none">
        <a class="nav-link dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
          <i class="fa fa-user fa-fw"></i> '. $_SESSION["name"] .'
        </a>
        <div class="dropdown-menu" aria-labelledby="userMenu">
          <a class="dropdown-item" href="/p/dashboard"><i class=""></i> Dashboard</a>';
 
          if($user->is_user()) {
            echo '<button class="dropdown-item btn btn-link" type="button" data-toggle="modal" data-target="#booking_modal">ทำการจอง</button>';
          }
          echo '
          <div class="dropdown-divider"></div>
          <form method="post" action="" id="logout">
            <button class="dropdown-item btn btn-link" type="submit"><i class="fa fa-sign-out"></i> Logout</button>
            <input type="hidden" name="isLogout" value="true" />
          </form>
        </div>
      </li>

      <li class="nav-item px-1 d-lg-none">
        <a class="nav-link"><i class="fa fa-user fa-fw"></i> '. $_SESSION["name"] .'</a>
      </li>
      <li class="nav-item px-1 d-lg-none">
        <a class="nav-link" href="/p/dashboard"><i class=""></i> Dashboard</a>
      </li>
      <li class="nav-item px-1 d-lg-none">';
      if($user->is_user()){
        echo '<a class="nav-link" data-toggle="modal" data-target="#booking_modal" style="cursor: pointer;">ทำการจอง</a>';
      }
      echo '</li>
      <li class="nav-item px-1 d-lg-block">
        <form method="post" action="" id="logout">
          <button class="nav-link btn btn-link" type="submit"><i class="fa fa-sign-out fa-fw"></i> Logout</button>
          <input type="hidden" name="isLogout" value="true" />
        </form>
      </li>
      ';
      
    }else{ 
      echo '
      <li class="nav-item">
        <a class="nav-link" href="/p/register"><i class="fa fa-id-card-o fa-fw" aria-hidden="true"></i> สมัครสมาชิก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/p/login"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i> เข้าสู่ระบบ</a>
      </li> ';
    }
    ?>
    </ul>
  </div>
</nav>


<!-- Booking modal -->
<div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="booking">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="booking">ทำการจอง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" action="" name="bookingForm" id="bookingForm">
          <div class="form-group text-center">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="switch_book" value="st" onclick="getSelectBooking(this.value)"> เลือกจากรายชื่อแพทย์
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="switch_book" value="dt" onclick="getSelectBooking(this.value)"> เลือกจากวันที่
              </label>
            </div>
            <div id="bookForm"></div>
          </div>
          <input type="hidden" name="isBooking" value="true">
          <input type="hidden" name="uid" value="<?php echo $_SESSION["id"]; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="bookingForm" class="btn btn-success">ทำการจอง</button>
      </div>
    </div>
  </div>
</div>

<script>
  function getSelectBooking(str){
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("bookForm").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","/p/public/template/bookForm.php?q="+str,true);
    xmlhttp.send();
  }

  function getStImage(val){
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("stImage").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","/p/public/template/stImage.php?q="+val,true);
    xmlhttp.send();
  }
  
  function getDtStaff(date) {
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        document.getElementById("dtStaff").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "/p/public/template/dtStaff.php?q="+date, true);
    xmlhttp.send();
  }
</script>
