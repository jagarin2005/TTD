<?php include_once("../config/conn.php"); ?>
<!DOCTYPE html>
<html>
<?php include_once('./template/head.php'); ?>
<body>
  <?php include_once('./template/navbar.php'); ?>
  <?php 
      include_once('./template/cover.php');
      // include_once('./template/carousel.php');
  ?>
  <div class="py-5 section" id="product">
    <div class="container px-5">
      <div class="row text-center">
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5 section" id="service">
    <div class="container px-5">
      <div class="row text-center">
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
        <div class="col-md-4">
          <h2 class="text-sm-center text-primary">HEADING</h2>
          <p class="text-justify my-1">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
            pretium quis, sem. </p>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5 section" id="contact">
    <div class="container px-5">
      <div class="row">
        <div class="col-md-8">
          <h2>สถานที่ตั้ง</h2>
          <iframe frameborder="0" style="border:0;width:100%;height:auto;min-height: 500px;" src="https://www.google.com/maps/embed/v1/place?q=%E0%B8%84%E0%B8%A5%E0%B8%B4%E0%B8%99%E0%B8%B4%E0%B8%81%E0%B9%81%E0%B8%9E%E0%B8%97%E0%B8%A2%E0%B9%8C%E0%B9%81%E0%B8%9C%E0%B8%99%E0%B9%84%E0%B8%97%E0%B8%A2%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%A2%E0%B8%B8%E0%B8%81%E0%B8%95%E0%B9%8C%20%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B8%A3%E0%B8%B2%E0%B8%8A%E0%B8%A0%E0%B8%B1%E0%B8%8E%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%99%E0%B8%84%E0%B8%A3&key=AIzaSyDd-PG92kcCi3P99osz4lM0HMoa9eC5-RM" allowfullscreen></iframe>
        </div>
        <div class="col-md-4">
          <h2>Facebook Page</h2>
          <div class="col-12">
            <div class="fb-page card" data-href="https://www.facebook.com/PNIC.Applied.Thai.Traditional.Medicine/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/PNIC.Applied.Thai.Traditional.Medicine/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/PNIC.Applied.Thai.Traditional.Medicine/">การแพทย์แผนไทยประยุกต์ วิทยาลัยนานาชาติพระนคร มหาวิทยาลัยราชภัฏพระนคร</a></blockquote></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5 section" id="about">
    <div class="container px-5">
      <div class="row">
        
      </div>
    </div>
  </div>
      

  <div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.10&appId=192672697804532";
      fjs.parentNode.insertBefore(js, fjs);
    }
    (document, 'script', 'facebook-jssdk'));
  </script>
  <?php include_once('./template/footer.php') ?>
  <?php include_once('./template/footer.js.php') ?>
</body>

</html>