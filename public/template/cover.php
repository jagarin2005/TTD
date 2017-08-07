<!-- Cover  -->
<?php include_once("../config/conn.php"); ?>
 <div class="jumbotron mt-3">
    <div class="container px-5 text-center">
      <div class="row">
        <div class="col-md-12 hidden-md-up my-3">
          
        </div>
        <div class="col-md-12">
          <img class="img-fluid" width="600" height="150" src="./public/img/logo.png" alt="logo">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-4 pt-3">พระนครคลินิกการแพทย์แผนไทยประยุกต์</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h2 class="subtitle text-muted pb-3">มหาวิทยาลัยราชภัฎพระนคร</h2>
        </div>
      </div>
      <div class="row py-1">
        <div class="col-12">
          <?php
          if(!$user->is_loggedin()){ 
            echo '<a class="btn btn-outline-success btn-lg m-1" href="/p/register"><i class="fa fa-id-card-o" aria-hidden="true"></i> สมัครสมาชิก</a>';
            echo '<a class="btn btn-outline-success btn-lg m-1" href="/p/login"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div> 