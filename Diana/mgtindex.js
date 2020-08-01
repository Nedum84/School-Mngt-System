$(document).ready(function(){
	// 1st carousel, main
	$('.carousel-main').flickity({
		setGallerySet:false,
		pageDots: true,
		autoPlay: 3000,
		prevNextButtons: false,
		resize:false,
		bgLazyLoad:1,
		wrapAround:true
	});
	// 2nd carousel, navigation
	$('.carousel-nav').flickity({
	  asNavFor: '.carousel-main',
	  contain: true,
	  pageDots: false,
	  setGallerySet:false,
	  autoPlay: 3000,
	  resize:true,
	  bgLazyLoad:1
	});

	$('.main-carousel').flickity({
		setGallerySet:false,
		pageDots: true,
		autoPlay: 9000,
		prevNextButtons: false,
		resize:true,
		bgLazyLoad:1,
		wrapAround:true
	});

	alert($(window).width());

});