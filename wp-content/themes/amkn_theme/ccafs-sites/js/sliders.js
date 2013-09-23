
   jQuery(document).ready(function($) {
      // Video Slider
      $('.slider-video').bxSlider({
         slideWidth: 450,
         minSlides: 1,
         maxSlides: 1,
         slideMargin: 10,
         controls: false,
         pager: true,
         auto: true
      });
      // Photo Slider
      $('.slider-photos').bxSlider({
         slideWidth: 500,
         minSlides: 6,
         maxSlides: 10,
         slideMargin: 1,
         controls: true,
         pager: false,
         auto: true
      });
   });
 