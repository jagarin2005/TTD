
<div class="col-md-3 col-lg-2 float-left col-1 pl-0 pr-0 collapse width show" id="sidebar">
  <div class="list-group border-0 card text-center text-md-left">
    <a href="/p/dashboard" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-dashboard"></i> <span class="hidden-sm-down">Welcome</span></a>
    
    <?php
    if($user->is_user()){
      echo '<a href="/p/userCheck" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-pencil-square-o fa-fw"></i> <span class="hidden-sm-down">บันทึกอาการ</span></a>
            <a href="/p/userAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-info fa-fw"></i> <span class="hidden-sm-down">การนัดหมาย</span></a>
            <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star-o fa-fw"></i> <span class="hidden-sm-down">ให้คะแนน</span></a>
            ';
    }
    if($user->is_admin()){
      echo '<a href="/p/manageUser" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-user fa-fw"></i> <span class="hidden-sm-down">การจัดการผู้ใช้</span></a>
            <a href="/p/manageShifts" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list fa-fw"></i> <span class="hidden-sm-down">วันที่เข้าปฏิบัติงาน</span></a>
            <a href="/p/manageAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list fa-fw"></i> <span class="hidden-sm-down">การนัดและการจอง</span></a>
            ';
    }
    if($user->is_staff()) {
      echo '
            <a href="/p/staffCheck" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-pencil-square-o fa-fw"></i> <span class="hidden-sm-down">บันทึกการรักษา</span></a>
            <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star fa-fw"></i> <span class="hidden-sm-down">ดูคะแนน*</span></a>
            <a href="/p/staffShifts" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-info fa-fw"></i> <span class="hidden-sm-down">วันที่เข้าปฏิบัติงาน</span></a>
            <a href="/p/staffAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-feed fa-fw"></i> <span class="hidden-sm-down">การนัดและจอง</span></a>
            ';
    }
    ?>
    <?php 
    if($user->is_loggedin()) {
      echo '
        <a href="#" id="logout_side" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-sign-out"></i> <span class="hidden-sm-down">Logout</span></a>
      ';
    }
    ?>
  </div>
</div>
<script>
  $("#logout_side").click(function() {
    $("#logout").submit();
  });
</script>