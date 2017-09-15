$(document).ready(function(){
	$('.slider-container').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 5000,
  		infinite: true,
  		speed: 300,
  		arrows: false,
  		dotsClass: 'slider-dots'
    });
});