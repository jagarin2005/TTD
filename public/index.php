<?php include_once("../config/conn.php"); ?>
<!DOCTYPE html>
<html>
<?php 
  ob_start();
  include_once('./template/head.php'); 
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "พระนครคลินิกการแพทย์แผนไทยประยุกต์";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<body data-spy="scroll" data-target="#navbarSupportedContent" data-offset="50">
  <?php include_once('./template/navbar.php'); ?>
  <?php 
      include_once('./template/cover.php');
      // include_once('./template/carousel.php');
?>

  <section class="container my-5 px-5">
    <div class="row">
      <h3>สินค้าจากทางคลินิก</h3>
      <div class="card-deck" id="product">
        <div class="card">
          <img class="card-img-top img-fluid" src="/p/public/img/product/c79.jpg" alt="Card image cap">
          <div class="card-body">
            <h4 class="card-title">ชุดของที่ระลึก จากผลิตภัณฑ์แปรรูปจากสมุนไพร</h4>
            <p class="card-text">จำหน่ายโดย การแพทย์แผนไทยประยุกต์ วิทยาลัยนานาชาติพระนคร มหาวิทยาลัยราชภัฏพระนคร</p>
            <p class="card-text">ราคา 79 บาท <span class="float-right">ติดต่อ...<a href="https://www.facebook.com/commerce/products/1572770876087037/?rid=2434901829898387&rt=6" style="color: rgba(59,89,152,1);"><i class="fa fa-facebook-square fa-2x fa-fw"></i></a></span></p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top img-fluid" src="/p/public/img/product/c100.jpg" alt="Card image cap">
          <div class="card-body">
             <h4 class="card-title">ชุดของที่ระลึก จากผลิตภัณฑ์แปรรูปจากสมุนไพร</h4>
            <p class="card-text">จำหน่ายโดย การแพทย์แผนไทยประยุกต์ วิทยาลัยนานาชาติพระนคร มหาวิทยาลัยราชภัฏพระนคร</p>
            <p class="card-text">ราคา 100 บาท  <span class="float-right">ติดต่อ...<a href="https://www.facebook.com/commerce/products/1096944553702802/?rid=2434901829898387&rt=6" style="color: rgba(59,89,152,1);"><i class="fa fa-facebook-square fa-2x fa-fw"></i></a></span></p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top img-fluid" src="/p/public/img/product/c120.jpg" alt="Card image cap">
          <div class="card-body">
             <h4 class="card-title">ชุดของที่ระลึก จากผลิตภัณฑ์แปรรูปจากสมุนไพร</h4>
            <p class="card-text">จำหน่ายโดย การแพทย์แผนไทยประยุกต์ วิทยาลัยนานาชาติพระนคร มหาวิทยาลัยราชภัฏพระนคร</p>
            <p class="card-text">ราคา 120 บาท  <span class="float-right">ติดต่อ...<a href="https://www.facebook.com/commerce/products/1359561494092406/?rid=2434901829898387&rt=6" style="color: rgba(59,89,152,1);"><i class="fa fa-facebook-square fa-2x fa-fw"></i></a></span></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="py-5 section" id="contact">
    <div class="container px-5">
      <div class="row">
        <div class="col-md-6">
          <h2>สถานที่ตั้ง</h2>
          <iframe class="card" frameborder="0" style="border:0;width:100%;height:auto;min-height: 500px;" src="https://www.google.com/maps/embed/v1/place?q=%E0%B8%84%E0%B8%A5%E0%B8%B4%E0%B8%99%E0%B8%B4%E0%B8%81%E0%B9%81%E0%B8%9E%E0%B8%97%E0%B8%A2%E0%B9%8C%E0%B9%81%E0%B8%9C%E0%B8%99%E0%B9%84%E0%B8%97%E0%B8%A2%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%A2%E0%B8%B8%E0%B8%81%E0%B8%95%E0%B9%8C%20%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B8%A3%E0%B8%B2%E0%B8%8A%E0%B8%A0%E0%B8%B1%E0%B8%8E%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%99%E0%B8%84%E0%B8%A3&key=AIzaSyDd-PG92kcCi3P99osz4lM0HMoa9eC5-RM" allowfullscreen></iframe>
        </div>
        <div class="col-md-6">
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