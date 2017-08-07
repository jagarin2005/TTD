<a href="javascript:void(0)" id="gototop"><i class="fa fa-chevron-up"></i></a>
<script>
  $(window).scroll(function() {
    if($(this).scrollTop() >= 70) {
      $('#gototop').fadeIn(200);
    }else{
      $('#gototop').fadeOut(200);
    }
  });

  clickTo('#gototop', 0);
  clickTo('#index_nav', 0);
  clickTo('#product_nav', 450);
  clickTo('#service_nav', 792);
  clickTo('#contact_nav', 1120);
  clickTo('#about_nav', 1700);

  function clickTo(id, pos) {
    $(id).click(function() {
      $('body,html').animate({
        scrollTop: pos
      }, 500);
    });
  }
  
</script>