
<div class="col-md-3 col-lg-2 float-left col-1 pl-0 pr-0 collapse width show" id="sidebar">
  <div class="list-group border-0 card text-center text-md-left">
    <a href="#menu1" class="list-group-item d-inline-block collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-dashboard"></i> <span class="hidden-sm-down">Item 1</span> </a>
    <div class="collapse" id="menu1">
      <a href="#" class="list-group-item" data-parent="#menu1">Subitem 1 </a>
      <a href="#" class="list-group-item" data-parent="#menu1">Subitem 2</a>
      <a href="#" class="list-group-item" data-parent="#menu1">Subitem 3</a>
    </div>
    <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-film"></i> <span class="hidden-sm-down">Item 2</span></a>
    <a href="#menu3" class="list-group-item d-inline-block collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-book"></i> <span class="hidden-sm-down">Item 3 </span></a>
    <div class="collapse" id="menu3">
      <a href="#" class="list-group-item" data-parent="#menu3">3.1</a>
      <a href="#" class="list-group-item" data-parent="#menu3">3.2 </a>
      <a href="#" class="list-group-item" data-parent="#menu3">3.3</a>
    </div>
    <?php
    if($user->is_admin()){
      echo '<a href="/p/manageUser" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-user"></i> <span class="hidden-sm-down">การจัดการผู้ใช้</span></a>
      <a href="/p/manageShifts" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list"></i> <span class="hidden-sm-down">กะเข้าทำงาน</span></a>
      <a href="/p/manageAppoint" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list"></i> <span class="hidden-sm-down">การนัดและการจอง</span></a>';
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