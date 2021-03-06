
<div class="col-md-3 col-lg-2 float-left px-0 collapse width show" id="sidebar">
  <div class="list-group border-0 card text-center text-md-left">
    <a href="/dashboard" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-home fa-fw"></i> <span class="d-none d-md-inline">หน้าหลัก</span></a>
    
    <?php
    if($user->is_user()){
      echo '
            <a href="/userAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-info fa-fw"></i> <span class="d-none d-md-inline">การนัดหมาย</span></a>
            <a href="/userCheck" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-pencil-square-o fa-fw"></i> <span class="d-none d-md-inline">บันทึกอาการ</span></a>
            <a href="/userRating" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star-o fa-fw"></i> <span class="d-none d-md-inline">ให้คะแนน</span></a>
            ';
    }
    if($user->is_admin()){
      echo '<a href="/manageUser" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-user fa-fw"></i> <span class="d-none d-md-inline">การจัดการผู้ใช้</span></a>
            <a href="/manageShifts" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list fa-fw"></i> <span class="d-none d-md-inline">วันที่เข้าปฏิบัติงาน</span></a>
            <a href="/manageAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list fa-fw"></i> <span class="d-none d-md-inline">การนัดและการจอง</span></a>
            <a href="/rank" id="rank_link" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star fa-fw"></i> <span class="d-none d-md-inline">ผลคะแนน</span></a>            
            ';
            // <a href="/setting" id="setting" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-cog fa-fw"></i> <span class="d-none d-md-inline">ตั้งค่า</span></a>
    }
    if($user->is_staff()) {
      echo '
            <a href="/staffAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-feed fa-fw"></i> <span class="d-none d-md-inline">การนัดและจอง</span></a>      
            <a href="/staffCheck" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-pencil-square-o fa-fw"></i> <span class="d-none d-md-inline">บันทึกการรักษา</span></a>
            <a href="/staffShifts" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-info fa-fw"></i> <span class="d-none d-md-inline">วันที่เข้าปฏิบัติงาน</span></a>            
            <a href="/staffRating" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star fa-fw"></i> <span class="d-none d-md-inline">ดูคะแนน</span></a>
            ';
    }
    ?>
    <?php 
    if($user->is_loggedin()) {
      echo '
        <a href="#" id="logout_side" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-sign-out"></i> <span class="d-none d-md-inline">Logout</span></a>
      ';
    }
    ?>
  </div>
</div>
<script>
  $("#logout_side").click(function() {
    $("#logout").submit();
  });
  $("#setting").hover(
    function(){$(".fa-cog").toggleClass("fa-spin")}
  )
</script>