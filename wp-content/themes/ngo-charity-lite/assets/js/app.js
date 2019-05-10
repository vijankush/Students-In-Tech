( function($){
    $('.ngo-banner-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        arrows: true,
    });

    //gallery
    $('.post-format-gallery').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: true
    });
    // Menu dropdown on hover
    extendNav();
    function extendNav() {
      jQuery('.nav-wrapper .dropdown').hover(function() {
        jQuery(this).children('.dropdown-menu').stop(true, true).show().addClass('animated-fast slfadeInDown');
        jQuery(this).toggleClass('open');
      }, function() {
        jQuery(this).children('.dropdown-menu').stop(true, true).hide().removeClass('animated-fast slfadeInDown');
        jQuery(this).toggleClass('open');
      });
    }

    $('[data-toggle="tooltip"]').tooltip();



    $(function() {
        $('.js-easy-pie-chart').easyPieChart({
                barColor:'#f6d187',
                scaleColor:false,
                lineWidth:10,
                lineCap:'circle',
                size: 80,
                trackColor: '#f5f5f5'
        });
    });

})(jQuery);

jQuery(window).load(function(){
     jQuery('.loader').fadeOut();
});

jQuery(window).scroll(function() {
  if (jQuery(this).scrollTop() > 100) {
        jQuery('.scroll-to-top').fadeIn();
    } else {
      jQuery('.scroll-to-top').fadeOut();
    }
});

jQuery('.scroll-to-top').on('click', function(e) {
  e.preventDefault();
    jQuery('html, body').animate({scrollTop : 0}, 800);
});
