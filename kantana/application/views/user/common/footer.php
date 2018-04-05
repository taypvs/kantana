<!-- End Contact -->
<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<![endif]-->
<!--[if IE 9]><!-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!--<![endif]-->

<script src="<?php echo base_url(); ?>asset/js/user/scripts.js"></script>
<script src="<?php echo base_url(); ?>asset/js/user/katana.js"></script>
<script src="<?php echo base_url(); ?>asset/js/user/jquery.clipthru.js"></script>
<script src="<?php echo base_url(); ?>asset/js/user/owl.carousel.min.js"></script>

<script type='text/javascript' src='https://maps.google.com/maps/api/js?sensor=false&#038;language=en&#038;key=AIzaSyChMUgKs4_sZTIAI_2TwtFrho8XFs2JL-8'></script>
<script>
  $(document).ready(function(){
    $(".owl-carousel").owlCarousel({
      loop:true,
      margin:10,
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:true
        },
        600:{
          items:3,
          nav:false
        },
        1000:{
          items:5,
          nav:false,
          loop:true
        }
      },
      autoplay:true,
      autoplayTimeout:1000,
      autoplayHoverPause:true
    });

    window.smoothScroll = function(target) {
      var scrollContainer = target;
    do { //find scroll container
      scrollContainer = scrollContainer.parentNode;
      if (!scrollContainer) return;
      scrollContainer.scrollTop += 1;
    } while (scrollContainer.scrollTop == 0);

    var targetY = 0;
    do { //find the top of target relatively to the container
      if (target == scrollContainer) break;
      targetY += target.offsetTop;
    } while (target = target.offsetParent);

    scroll = function(c, a, b, i) {
      i++; if (i > 30) return;
      c.scrollTop = a + (b - a) / 30 * i;
      setTimeout(function(){ scroll(c, a, b, i); }, 20);
    }
    // start scrolling
    scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
    }
});

</script>

</body>
</html>
